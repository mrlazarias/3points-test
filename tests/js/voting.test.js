import { VotingSystem } from '../../resources/js/voting.js';

// Mock DOM environment
const mockDOM = () => {
    // Mock meta tag for CSRF token
    const meta = document.createElement('meta');
    meta.setAttribute('name', 'csrf-token');
    meta.setAttribute('content', 'mock-csrf-token');
    document.head.appendChild(meta);

    // Mock vote button
    const button = document.createElement('button');
    button.className = 'vote-btn';
    button.dataset.voteableType = 'post';
    button.dataset.voteableId = '1';
    button.dataset.voteType = 'up';
    button.id = 'post-upvote-1';
    document.body.appendChild(button);

    // Mock vote count elements
    const upCount = document.createElement('span');
    upCount.id = 'post-upvote-count-1';
    upCount.textContent = '0';
    document.body.appendChild(upCount);

    const downCount = document.createElement('span');
    downCount.id = 'post-downvote-count-1';
    downCount.textContent = '0';
    document.body.appendChild(downCount);

    // Mock downvote button
    const downButton = document.createElement('button');
    downButton.className = 'vote-btn';
    downButton.dataset.voteableType = 'post';
    downButton.dataset.voteableId = '1';
    downButton.dataset.voteType = 'down';
    downButton.id = 'post-downvote-1';
    document.body.appendChild(downButton);

    return { button, upCount, downCount, downButton };
};

describe('VotingSystem', () => {
    beforeEach(() => {
        // Clear DOM
        document.head.innerHTML = '';
        document.body.innerHTML = '';

        // Reset fetch mock
        global.fetch.mockClear();

        // Reset console methods
        global.console.error.mockClear();
    });

    describe('getCsrfToken', () => {
        it('should get CSRF token from meta tag', () => {
            const meta = document.createElement('meta');
            meta.setAttribute('name', 'csrf-token');
            meta.setAttribute('content', 'test-token');
            document.head.appendChild(meta);

            const votingSystem = new VotingSystem();
            expect(votingSystem.csrfToken).toBe('test-token');
        });

        it('should return null if CSRF token meta tag is not found', () => {
            const votingSystem = new VotingSystem();
            expect(votingSystem.csrfToken).toBeNull();
        });
    });

    describe('handleVoteClick', () => {
        it('should send vote request with correct parameters', async () => {
            const { button } = mockDOM();

            // Mock successful fetch response
            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true, likes_count: 5, dislikes_count: 0 }),
            });

            const votingSystem = new VotingSystem();
            await votingSystem.handleVoteClick(button);

            expect(global.fetch).toHaveBeenCalledWith('/vote', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': 'mock-csrf-token',
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    voteable_type: 'post',
                    voteable_id: '1',
                    vote_type: 'up',
                }),
            });
        });

        it('should update vote counts when request is successful', async () => {
            const { button, upCount, downCount } = mockDOM();

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true, likes_count: 5, dislikes_count: 2 }),
            });

            const votingSystem = new VotingSystem();
            await votingSystem.handleVoteClick(button);

            expect(upCount.textContent).toBe('5');
            expect(downCount.textContent).toBe('2');
        });

        it('should handle vote request failure', async () => {
            const { button } = mockDOM();

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: false, message: 'Vote failed' }),
            });

            const votingSystem = new VotingSystem();
            await votingSystem.handleVoteClick(button);

            expect(global.console.error).toHaveBeenCalledWith('Vote failed:', 'Vote failed');
        });

        it('should handle fetch errors', async () => {
            const { button } = mockDOM();

            global.fetch.mockRejectedValueOnce(new Error('Network error'));

            const votingSystem = new VotingSystem();
            await votingSystem.handleVoteClick(button);

            expect(global.console.error).toHaveBeenCalledWith('Error voting:', expect.any(Error));
        });

        it('should disable button during request and re-enable after', async () => {
            const { button } = mockDOM();

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true }),
            });

            const votingSystem = new VotingSystem();

            // Initially button should be enabled
            expect(button.disabled).toBe(false);

            const votePromise = votingSystem.handleVoteClick(button);

            // During request, button should be disabled
            expect(button.disabled).toBe(true);

            await votePromise;

            // After request, button should be enabled again
            expect(button.disabled).toBe(false);
        });

        it('should not make request if button is missing data attributes', async () => {
            const button = document.createElement('button');
            button.className = 'vote-btn';
            // Missing data attributes

            const votingSystem = new VotingSystem();
            await votingSystem.handleVoteClick(button);

            expect(global.fetch).not.toHaveBeenCalled();
            expect(global.console.error).toHaveBeenCalledWith('Missing vote data attributes');
        });
    });

    describe('updateButtonStates', () => {
        it('should add active styling to upvote button', () => {
            const { button, downButton } = mockDOM();

            const votingSystem = new VotingSystem();
            votingSystem.updateButtonStates('post', '1', 'up');

            expect(button.classList.contains('!bg-emerald-500/20')).toBe(true);
            expect(button.classList.contains('!text-emerald-500')).toBe(true);
            expect(button.classList.contains('!border-emerald-500/30')).toBe(true);

            expect(downButton.classList.contains('!bg-red-500/20')).toBe(false);
        });

        it('should add active styling to downvote button', () => {
            const { button, downButton } = mockDOM();

            const votingSystem = new VotingSystem();
            votingSystem.updateButtonStates('post', '1', 'down');

            expect(downButton.classList.contains('!bg-red-500/20')).toBe(true);
            expect(downButton.classList.contains('!text-red-500')).toBe(true);
            expect(downButton.classList.contains('!border-red-500/30')).toBe(true);

            expect(button.classList.contains('!bg-emerald-500/20')).toBe(false);
        });

        it('should remove existing active states before adding new ones', () => {
            const { button, downButton } = mockDOM();

            // Add initial state
            button.classList.add('!bg-emerald-500/20', '!text-emerald-500');

            const votingSystem = new VotingSystem();
            votingSystem.updateButtonStates('post', '1', 'down');

            // Upvote button should have its styling removed
            expect(button.classList.contains('!bg-emerald-500/20')).toBe(false);

            // Downvote button should have new styling
            expect(downButton.classList.contains('!bg-red-500/20')).toBe(true);
        });
    });

    describe('Static votePost method', () => {
        it('should vote on post and update UI', async () => {
            const { upCount, downCount } = mockDOM();

            global.fetch.mockResolvedValueOnce({
                json: async () => ({ success: true, likes_count: 3, dislikes_count: 1 }),
            });

            const result = await VotingSystem.votePost('1', 'up');

            expect(result.success).toBe(true);
            expect(upCount.textContent).toBe('3');
            expect(downCount.textContent).toBe('1');
        });
    });
});
