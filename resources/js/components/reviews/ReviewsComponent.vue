<template>
    <div class="container">
        <div class="categories-index-container">
            <div class="filter-buttons">
                <button 
                    v-for="n in 5" 
                    :key="n"
                    :class="{ active: selectedFilter === n }"
                    @click="toggleFilter(n)"
                    class="filter-btn"
                >
                    {{ n }}
                </button>
            </div>

            <div class="reviews-list">
                <div v-for="review in filteredReviews" :key="review.id" class="review-item">
                    <div class="review-header">
                        <div class="review-date">
                            <span class="date">{{ formatDate(review.created_at) }}</span>
                            <span class="time">{{ formatTime(review.created_at) }}</span>
                        </div>
                        <div class="stars">
                            <span v-for="n in 5" :key="n">
                                <span v-if="n <= review.stars" class="star filled">★</span>
                                <span v-else class="star">★</span>
                            </span>
                        </div>
                    </div>
                    <div class="review-content" v-if="review.comment">
                        <p class="review-text">"{{ review.comment }}"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        reviews: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selectedFilter: null
        }
    },
    computed: {
        sortedReviews() {
            return [...this.reviews].sort((a, b) => {
                return new Date(b.created_at) - new Date(a.created_at)
            })
        },
        filteredReviews() {
            if (!this.selectedFilter) {
                return this.sortedReviews
            }
            return this.sortedReviews.filter(review => review.stars === this.selectedFilter)
        }
    },
    methods: {
        formatDate(date) {
            const d = new Date(date)
            return `${d.getDate()}.${d.getMonth() + 1}.${d.getFullYear()}`
        },
        formatTime(date) {
            const d = new Date(date)
            return `${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`
        },
        toggleFilter(stars) {
            if (this.selectedFilter === stars) {
                this.selectedFilter = null
            } else {
                this.selectedFilter = stars
            }
        }
    }
}
</script>

<style scoped>
.reviews-container {
    background-color: #f5f5f5;
    min-height: 100vh;
}

.filter-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 1rem 0;
}

.filter-btn {
    padding: 8px 16px;
    border: 1px solid #2B6777;
    background-color: white;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn.active {
    background-color: #2B6777;
    color: white;
}

.header {
    background-color: #2B6777;
    color: white;
    padding: 1rem;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header h1 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 500;
}

.reviews-list {
    padding: 1rem;
}

.review-item {
    background-color: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.review-date {
    display: flex;
    gap: 0.5rem;
    color: #666;
    font-size: 0.9rem;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    color: #ddd;
    font-size: 1rem;
}

.star.filled {
    color: #FFD700;
}

.review-content {
    margin-top: 0.5rem;
}

.review-text {
    margin: 0;
    color: #333;
    font-size: 0.9rem;
    line-height: 1.4;
}
</style>