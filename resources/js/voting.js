/**
 * Voting system functionality
 */

class VotingSystem {
    constructor() {
        this.csrfToken = this.getCsrfToken();
        this.init();
    }

    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : null;
    }

    init() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.vote-btn')) {
                e.preventDefault();
                this.handleVoteClick(e.target.closest('.vote-btn'));
            }
        });
    }

    async handleVoteClick(button) {
        const voteableType = button.dataset.voteableType;
        const voteableId = button.dataset.voteableId;
        const voteType = button.dataset.voteType;

        if (!voteableType || !voteableId || !voteType) {
            console.error('Missing vote data attributes');
            return;
        }

        // Disable button temporarily
        button.disabled = true;

        try {
            const response = await fetch('/vote', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    voteable_type: voteableType,
                    voteable_id: voteableId,
                    vote_type: voteType,
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.updateVoteDisplay(voteableType, voteableId, data);
                this.updateButtonStates(voteableType, voteableId, voteType);
            } else {
                console.error('Vote failed:', data.message || 'Unknown error');
            }
        } catch (error) {
            console.error('Error voting:', error);
        } finally {
            button.disabled = false;
        }
    }

    updateVoteDisplay(voteableType, voteableId, data) {
        const upCount = document.getElementById(`${voteableType}-upvote-count-${voteableId}`);
        const downCount = document.getElementById(`${voteableType}-downvote-count-${voteableId}`);

        if (upCount && data.likes_count !== undefined) {
            upCount.textContent = data.likes_count;
        }
        if (downCount && data.dislikes_count !== undefined) {
            downCount.textContent = data.dislikes_count;
        }
    }

    updateButtonStates(voteableType, voteableId, voteType) {
        const upButton = document.getElementById(`${voteableType}-upvote-${voteableId}`);
        const downButton = document.getElementById(`${voteableType}-downvote-${voteableId}`);

        // Remove all active states
        [upButton, downButton].forEach((button) => {
            if (button) {
                button.classList.remove('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                button.classList.remove('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
            }
        });

        // Add active state to the clicked button
        const activeButton = document.getElementById(`${voteableType}-${voteType}vote-${voteableId}`);
        if (activeButton) {
            if (voteType === 'up') {
                activeButton.classList.add('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
            } else {
                activeButton.classList.add('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
            }
        }
    }

    // Static method for voting posts (legacy compatibility)
    static async votePost(postId, voteType) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const response = await fetch('/vote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                Accept: 'application/json',
            },
            body: JSON.stringify({
                voteable_type: 'post',
                voteable_id: postId,
                vote_type: voteType,
            }),
        });

        const data = await response.json();

        if (data.success) {
            // Update counts
            const upCount = document.getElementById(`post-upvote-count-${postId}`);
            const downCount = document.getElementById(`post-downvote-count-${postId}`);

            if (upCount) upCount.textContent = data.likes_count || 0;
            if (downCount) downCount.textContent = data.dislikes_count || 0;

            // Reset active states
            const upButton = document.getElementById(`post-upvote-${postId}`);
            const downButton = document.getElementById(`post-downvote-${postId}`);

            [upButton, downButton].forEach((button) => {
                if (button) {
                    button.classList.remove('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                    button.classList.remove('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
                }
            });

            // Add active state to clicked button
            const activeButton = document.getElementById(`post-${voteType}vote-${postId}`);
            if (activeButton) {
                if (voteType === 'up') {
                    activeButton.classList.add('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                } else {
                    activeButton.classList.add('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
                }
            }
        }

        return data;
    }
}

// Initialize voting system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new VotingSystem();
});

// Export for testing
export { VotingSystem };
