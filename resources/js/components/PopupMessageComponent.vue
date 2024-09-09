<template>
    <transition name="slide-fade">
      <div v-if="isVisible" :class="`toast toast--${type}`">
        <p class="toast__message">{{ message }}</p>
      </div>
    </transition>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isVisible: false,
        type: '', // success or error
        message: '', // text to be displayed
      }
    },
    methods: {
        showMessage(type, message) {
        this.type = type;
        this.message = message;
        this.isVisible = true;
        setTimeout(() => {
          this.isVisible = false;
        }, 2200);
      },
    },
  }
  </script>
  
  <style scoped>
  .toast {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 1em;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }
  .toast--success {
    background: #d4edda;
    color: #155724;
  }
  .toast--error {
    background: #f8d7da;
    color: #721c24;
  }
  .slide-fade-enter-active {
    transition: all 0.3s ease;
  }
  .slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
  }
  .slide-fade-enter, .slide-fade-leave-to {
    transform: translateY(30px);
    opacity: 0;
  }
  </style>
  