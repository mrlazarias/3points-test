/**
 * Comments system functionality
 */

class CommentsSystem {
    constructor() {
        this.csrfToken = this.getCsrfToken();
        this.init();
    }

    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : null;
    }

    init() {
        // Initialize comment form submission
        const commentForm = document.getElementById('comment-form');
        if (commentForm) {
            commentForm.addEventListener('submit', (e) => this.handleCommentSubmit(e));
        }
    }

    async handleCommentSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const content = formData.get('content');

        if (!content || content.trim() === '') {
            return null;
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                // Clear the form
                const contentField = document.getElementById('comment-content');
                if (contentField) {
                    contentField.value = '';
                }

                // Update comment count if provided
                if (data.comment_count !== undefined) {
                    this.updateCommentCount(data.comment_count);
                }

                return data;
            } else {
                console.error('Comment submission failed:', data.message || 'Unknown error');
                return null;
            }
        } catch (error) {
            console.error('Error submitting comment:', error);
            return null;
        }
    }

    updateCommentCount(count) {
        const countElements = document.querySelectorAll('.comment-count');
        countElements.forEach((element) => {
            element.textContent = count;
        });
    }

    toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form) {
            form.classList.toggle('hidden');
        }
    }

    async deleteComment(commentId) {
        if (!confirm('Tem certeza que deseja excluir este comentário?')) {
            return false;
        }

        try {
            const response = await fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                },
            });

            const data = await response.json();

            if (data.success) {
                const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
                if (commentElement) {
                    commentElement.remove();
                }
                return true;
            } else {
                console.error('Failed to delete comment:', data.message || 'Unknown error');
                return false;
            }
        } catch (error) {
            console.error('Error deleting comment:', error);
            return false;
        }
    }
}

// Make functions globally available for inline use
window.toggleReplyForm = function (commentId) {
    const commentsSystem = new CommentsSystem();
    commentsSystem.toggleReplyForm(commentId);
};

window.deleteComment = async function (commentId) {
    const commentsSystem = new CommentsSystem();
    return await commentsSystem.deleteComment(commentId);
};

// Initialize comments system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new CommentsSystem();
});

// Export for testing
export { CommentsSystem };
