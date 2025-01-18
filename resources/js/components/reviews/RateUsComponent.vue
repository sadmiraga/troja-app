<template>
    <div class="review-container">
      <div class="logo-container">
        <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" alt="Google Logo" class="google-logo">
        <img :src="`/images_dynamic/settings/${settings.logo}`" alt="Business Logo" class="business-image" style="height: 50px;">
        
      </div>
      <div class="review-form">
        <h1>{{ submitted ? 'Thank you' : 'Leave a Review' }}</h1>
        <div v-if="!submitted" class="star-rating">
          <input type="radio" id="star5" name="rating" value="5" v-model="rating" @change="handleRatingChange" :disabled="isRatingSelected" />
          <label :class="{ disabled: isRatingSelected }" for="star5">&#9733;</label>
          <input type="radio" id="star4" name="rating" value="4" v-model="rating" @change="handleRatingChange" :disabled="isRatingSelected" />
          <label :class="{ disabled: isRatingSelected }" for="star4">&#9733;</label>
          <input type="radio" id="star3" name="rating" value="3" v-model="rating" @change="handleRatingChange" :disabled="isRatingSelected" />
          <label :class="{ disabled: isRatingSelected }" for="star3">&#9733;</label>
          <input type="radio" id="star2" name="rating" value="2" v-model="rating" @change="handleRatingChange" :disabled="isRatingSelected" />
          <label :class="{ disabled: isRatingSelected }" for="star2">&#9733;</label>
          <input type="radio" id="star1" name="rating" value="1" v-model="rating" @change="handleRatingChange" :disabled="isRatingSelected" />
          <label :class="{ disabled: isRatingSelected }" for="star1">&#9733;</label>
        </div>
        <textarea v-if="showTextarea && !submitted" v-model="message" placeholder="Share details of your experience at this place" class="w-100 w-md-auto"></textarea>
        <button v-if="showPostButton && !submitted" type="button" @click="submitReview">Post Review</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ["settings"],

    mounted(){
      console.log(this.settings);
    },
    data() {
      return {
        rating: 0,
        message: '',
        showTextarea: false,
        showPostButton: false,
        isRatingSelected: false,
        submitted: false
      };
    },
    methods: {
      handleRatingChange() {
        if (!this.isRatingSelected) {
          this.isRatingSelected = true;
          
          if (this.rating <= 3) {
            this.showTextarea = true;
            this.showPostButton = true;
          } else {
            this.store();
          }
        }
      },
      async submitReview() {
        if (!this.message) {
          alert('Upišite komentar');
          return;
        }
        this.store();
      },
      store(){
            const filter_url = `/rate-us/store`;
            return new Promise(resolve => {
                window.axios.post(filter_url, {
                    rating: this.rating,
                    comment: this.message
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {

                    if(response.data == "success"){

                        if(this.rating > 3){
                            window.location.href = this.settings.google_review_link;
                        } else {
                            this.submitted = true;
                        }
                        
                    }
                    
                }).then(response => {}).catch(error => {})
            });
        },
    }
  };
  </script>
  
  <style scoped>
  body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5; /* Light background for contrast */
    margin: 0;
    padding: 20px;
  }
  
  .review-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 100%;
    height: 100vh;
    margin-top: 0px !important;
    margin: 50px auto 0;
    padding: 20px;
    background-color: white; /* Ensure background is white */
    border-radius: 8px; /* Add some rounding */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ensure shadow is applied */
  }
  
  .logo-container {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 20px;
  }
  
  .business-image {
    width: auto;
    height: 80px;
    object-fit: contain;
  }
  
  .google-logo {
    width: auto;
    height: 50px;
  }
  
  .review-form {
    width: 100%;
    padding: 24px;
  }
  
  h1 {
    color: #202124;
    font-size: 28px;
    margin-bottom: 24px;
    text-align: center;
  }
  
  .star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    margin-bottom: 16px;
  }
  
  .star-rating input {
    display: none;
  }
  
  .star-rating label {
    color: #dadce0;
    font-size: 48px;
    padding: 0 2px;
    cursor: pointer;
  }

  .star-rating label.disabled {
    cursor: not-allowed;
    opacity: 0.7;
  }
  
  .star-rating label:hover:not(.disabled),
  .star-rating label:hover:not(.disabled) ~ label,
  .star-rating input:checked ~ label {
    color: #fbbc04;
  }
  
  textarea {
    width: 100%;
    height: 100px;
    padding: 8px;
    border: 1px solid #dadce0;
    border-radius: 4px;
    resize: vertical;
    margin-bottom: 16px;
  }
  
  button {
    background-color: #1a73e8;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    width: 100%;
    max-width: 200px;
    display: block;
    margin: 0 auto;
  }
  
  button:hover {
    background-color: #1765cc;
  }
  </style>