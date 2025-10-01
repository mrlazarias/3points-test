import { CommentsSystem } from '../../resources/js/comments.js';

const mockDOM = () => {
    // Mock comment form
    const form = document.createElement('form');
    form.id = 'comment-form';
    form.action = '/comments';
    document.body.appendChild(form);

    // Mock textarea
    const textarea = document.createElement('textarea');
    textarea.id = 'comment-content';
    textarea.name = 'content';
    form.appendChild(textarea);

    // Mock comment count elements
    const countElement = document.createElement('span');
    countElement.className = 'comment-count';
    countElement.textContent = '0';
    document.body.appendChild(countElement);

    return { form, textarea, countElement };
};

describe('CommentsSystem', () => {
    let meta;

    beforeEach(() => {
        // Clear DOM
        document.head.innerHTML = '';
        document.body.innerHTML = '';

        // Add CSRF token meta tag
        meta = document.createElement('meta');
        meta.setAttribute('name', 'csrf-token');
        meta.setAttribute('content', 'mock-csrf-token');
        document.head.appendChild(meta);

        // Reset fetch mock
        global.fetch.mockClear();

        // Reset console methods
        global.console.error.mockClear();

        // Reset confirm
        global.confirm = jest.fn(() => true);
    });

    describe('getCsrfToken', () => {
        it('should get CSRF token from meta tag', () => {
            // The meta tag is already added in beforeEach
            const commentsSystem = new CommentsSystem();
            expect(commentsSystem.csrfToken).toBe('mock-csrf-token');
        });

        it('should return null if CSRF token meta tag is not found', () => {
            // Remove the meta tag for this test
            document.head.innerHTML = '';

            const commentsSystem = new CommentsSystem();
            expect(commentsSystem.csrfToken).toBeNull();
        });
    });

    describe('handleCommentSubmit', () => {
        it('should submit comment with correct parameters', async () => {
            const { form, textarea } = mockDOM();
            textarea.value = 'Test comment';

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true, comment_count: 1 }),
            });

            const commentsSystem = new CommentsSystem();

            // Mock FormData.get to return the textarea value
            const formDataGetSpy = jest.spyOn(FormData.prototype, 'get');
            formDataGetSpy.mockReturnValue('Test comment');

            const event = new Event('submit', { bubbles: true, cancelable: true });
            jest.spyOn(event, 'preventDefault');
            Object.defineProperty(event, 'target', { value: form, enumerable: true });

            await commentsSystem.handleCommentSubmit(event);

            expect(event.preventDefault).toHaveBeenCalled();
            expect(global.fetch).toHaveBeenCalledWith(
                expect.stringContaining('/comments'),
                expect.objectContaining({
                    method: 'POST',
                    headers: expect.objectContaining({
                        'X-CSRF-TOKEN': 'mock-csrf-token',
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    }),
                }),
            );

            formDataGetSpy.mockRestore();
        });

        it('should not submit if content is empty', async () => {
            const { form, textarea } = mockDOM();
            textarea.value = '';

            const commentsSystem = new CommentsSystem();

            // Mock FormData.get to return empty string
            const formDataGetSpy = jest.spyOn(FormData.prototype, 'get');
            formDataGetSpy.mockReturnValue('');

            const event = new Event('submit', { bubbles: true, cancelable: true });
            Object.defineProperty(event, 'target', { value: form, enumerable: true });

            await commentsSystem.handleCommentSubmit(event);

            expect(global.fetch).not.toHaveBeenCalled();

            formDataGetSpy.mockRestore();
        });

        it('should clear textarea after successful submission', async () => {
            const { form, textarea } = mockDOM();
            textarea.value = 'Test comment';

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true }),
            });

            const commentsSystem = new CommentsSystem();

            // Mock FormData.get to return the textarea value
            const formDataGetSpy = jest.spyOn(FormData.prototype, 'get');
            formDataGetSpy.mockReturnValue('Test comment');

            const event = new Event('submit', { bubbles: true, cancelable: true });
            Object.defineProperty(event, 'target', { value: form, enumerable: true });

            await commentsSystem.handleCommentSubmit(event);

            expect(textarea.value).toBe('');

            formDataGetSpy.mockRestore();
        });

        it('should update comment count after successful submission', async () => {
            const { form, textarea, countElement } = mockDOM();
            textarea.value = 'Test comment';

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true, comment_count: 5 }),
            });

            const commentsSystem = new CommentsSystem();

            // Mock FormData.get
            const formDataGetSpy = jest.spyOn(FormData.prototype, 'get');
            formDataGetSpy.mockReturnValue('Test comment');

            const event = new Event('submit', { bubbles: true, cancelable: true });
            Object.defineProperty(event, 'target', { value: form, enumerable: true });

            await commentsSystem.handleCommentSubmit(event);

            expect(countElement.textContent).toBe('5');

            formDataGetSpy.mockRestore();
        });

        it('should handle submission failure', async () => {
            const { form, textarea } = mockDOM();
            textarea.value = 'Test comment';

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: false, message: 'Failed to submit' }),
            });

            const commentsSystem = new CommentsSystem();

            // Mock FormData.get
            const formDataGetSpy = jest.spyOn(FormData.prototype, 'get');
            formDataGetSpy.mockReturnValue('Test comment');

            const event = new Event('submit', { bubbles: true, cancelable: true });
            Object.defineProperty(event, 'target', { value: form, enumerable: true });

            const result = await commentsSystem.handleCommentSubmit(event);

            expect(result).toBeNull();
            expect(global.console.error).toHaveBeenCalledWith('Comment submission failed:', 'Failed to submit');

            formDataGetSpy.mockRestore();
        });

        it('should handle fetch errors', async () => {
            const { form, textarea } = mockDOM();
            textarea.value = 'Test comment';

            global.fetch.mockRejectedValueOnce(new Error('Network error'));

            const commentsSystem = new CommentsSystem();

            // Mock FormData.get
            const formDataGetSpy = jest.spyOn(FormData.prototype, 'get');
            formDataGetSpy.mockReturnValue('Test comment');

            const event = new Event('submit', { bubbles: true, cancelable: true });
            Object.defineProperty(event, 'target', { value: form, enumerable: true });

            const result = await commentsSystem.handleCommentSubmit(event);

            expect(result).toBeNull();
            expect(global.console.error).toHaveBeenCalledWith('Error submitting comment:', expect.any(Error));

            formDataGetSpy.mockRestore();
        });
    });

    describe('toggleReplyForm', () => {
        it('should toggle reply form visibility', () => {
            const replyForm = document.createElement('div');
            replyForm.id = 'reply-form-123';
            replyForm.classList.add('hidden');
            document.body.appendChild(replyForm);

            const commentsSystem = new CommentsSystem();
            commentsSystem.toggleReplyForm('123');

            expect(replyForm.classList.contains('hidden')).toBe(false);

            commentsSystem.toggleReplyForm('123');

            expect(replyForm.classList.contains('hidden')).toBe(true);
        });

        it('should do nothing if reply form does not exist', () => {
            const commentsSystem = new CommentsSystem();
            expect(() => commentsSystem.toggleReplyForm('999')).not.toThrow();
        });
    });

    describe('deleteComment', () => {
        it('should delete comment after confirmation', async () => {
            const commentElement = document.createElement('div');
            commentElement.setAttribute('data-comment-id', '123');
            document.body.appendChild(commentElement);

            global.confirm = jest.fn(() => true);
            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true }),
            });

            const commentsSystem = new CommentsSystem();
            const result = await commentsSystem.deleteComment('123');

            expect(global.confirm).toHaveBeenCalledWith('Tem certeza que deseja excluir este comentário?');
            expect(global.fetch).toHaveBeenCalledWith('/comments/123', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': 'mock-csrf-token',
                    'Content-Type': 'application/json',
                },
            });
            expect(result).toBe(true);
            expect(document.querySelector('[data-comment-id="123"]')).toBeNull();
        });

        it('should not delete if user cancels confirmation', async () => {
            global.confirm = jest.fn(() => false);

            const commentsSystem = new CommentsSystem();
            const result = await commentsSystem.deleteComment('123');

            expect(global.confirm).toHaveBeenCalled();
            expect(global.fetch).not.toHaveBeenCalled();
            expect(result).toBe(false);
        });

        it('should handle deletion failure', async () => {
            const commentElement = document.createElement('div');
            commentElement.setAttribute('data-comment-id', '123');
            document.body.appendChild(commentElement);

            global.confirm = jest.fn(() => true);
            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: false, message: 'Failed to delete' }),
            });

            const commentsSystem = new CommentsSystem();
            const result = await commentsSystem.deleteComment('123');

            expect(result).toBe(false);
            expect(global.console.error).toHaveBeenCalledWith('Failed to delete comment:', 'Failed to delete');
            // Element should still exist
            expect(document.querySelector('[data-comment-id="123"]')).not.toBeNull();
        });

        it('should handle fetch errors', async () => {
            const commentElement = document.createElement('div');
            commentElement.setAttribute('data-comment-id', '123');
            document.body.appendChild(commentElement);

            global.confirm = jest.fn(() => true);
            global.fetch.mockRejectedValueOnce(new Error('Network error'));

            const commentsSystem = new CommentsSystem();
            const result = await commentsSystem.deleteComment('123');

            expect(result).toBe(false);
            expect(global.console.error).toHaveBeenCalledWith('Error deleting comment:', expect.any(Error));
            // Element should still exist
            expect(document.querySelector('[data-comment-id="123"]')).not.toBeNull();
        });
    });

    describe('updateCommentCount', () => {
        it('should update all comment count elements', () => {
            const count1 = document.createElement('span');
            count1.className = 'comment-count';
            count1.textContent = '0';
            document.body.appendChild(count1);

            const count2 = document.createElement('span');
            count2.className = 'comment-count';
            count2.textContent = '0';
            document.body.appendChild(count2);

            const commentsSystem = new CommentsSystem();
            commentsSystem.updateCommentCount(42);

            expect(count1.textContent).toBe('42');
            expect(count2.textContent).toBe('42');
        });
    });
});
