<template>
  <div class="calculator-container">
    <form @submit.prevent="calculateEmptyBottleWeight" class="calculator-form">
      <div class="form-group">
        <label for="fullWeight" class="form-label">Full Bottle Weight (grams):</label>
        <input 
          type="number" 
          id="fullWeight" 
          v-model.number="fullWeight" 
          class="form-input"
          required 
        />
      </div>

      <div class="form-group">
        <label for="volume" class="form-label">Volume (liters):</label>
        <input 
          type="number" 
          id="volume" 
          step="0.01" 
          v-model.number="volume" 
          class="form-input"
          required 
        />
        <div class="button-group">
          <button type="button" class="btn btn-secondary" @click="setVolume(0.5)">0.5 L</button>
          <button type="button" class="btn btn-secondary" @click="setVolume(0.7)">0.7 L</button>
          <button type="button" class="btn btn-secondary" @click="setVolume(0.75)">0.75 L</button>
          <button type="button" class="btn btn-secondary" @click="setVolume(1)">1 L</button>
          <button type="button" class="btn btn-secondary" @click="setVolume(1.5)">1.5 L</button>
        </div>
      </div>

      <div class="form-group">
        <label for="type" class="form-label">Drink Type:</label>
        <select 
          id="type" 
          v-model="drinkType" 
          class="form-select"
          required
        >
          <option value="water">Water</option>
          <option value="beer">Beer</option>
          <option value="wine">Wine</option>
          <option value="spirits">Spirits</option>
          <option value="gin">Gin</option>
          <option value="whiskey">Whiskey</option>
          <option value="brandy">Brandy</option>
          <option value="vodka">Vodka</option>
          <option value="rum">Rum</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Calculate</button>
    </form>

    <div v-if="emptyWeight !== null" class="result-container">
      <h2 class="result-title">Results:</h2>
      <div class="d-flex" style="align-items: center;justify-content: space-between;">
        <p class="result-text">Empty Bottle Weight: ({{ emptyWeight }}) g</p>
        <button class="btn btn-copy" @click="copyToClipboard">Copy to Clipboard</button>
      </div>
    </div>

    <!-- Toast notification -->
    <div v-if="toastVisible" class="toast-notification">
      Value copied to clipboard!
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fullWeight: null,
      volume: null,
      drinkType: "water",
      emptyWeight: null,
      toastVisible: false, // State for toast notification
      densities: {
        water: 1000, // g/L
        beer: 1010, // g/L
        wine: 990,  // g/L
        spirits: 940, // g/L
        gin: 790, // g/L
        whiskey: 790, // g/L
        brandy: 950, // g/L
        vodka: 790, // g/L
        rum: 790 // g/L
      }
    };
  },
  methods: {
    setVolume(value) {
      this.volume = value;
    },
    calculateEmptyBottleWeight() {
      if (this.fullWeight && this.volume && this.drinkType) {
        const drinkDensity = this.densities[this.drinkType];
        const liquidWeight = this.volume * drinkDensity;
        this.emptyWeight = this.fullWeight - liquidWeight;
      } else {
        alert("Please fill in all fields correctly.");
      }
    },
    copyToClipboard() {
      if (this.emptyWeight !== null) {
        navigator.clipboard.writeText(this.emptyWeight.toString()).then(() => {
          this.showToast(); // Show toast notification
        }).catch(err => {
          console.error("Failed to copy: ", err);
        });
      }
    },
    showToast() {
      this.toastVisible = true;
      setTimeout(() => {
        this.toastVisible = false;
      }, 2000); // Hide toast after 2 seconds
    }
  }
};
</script>

<style scoped>
.calculator-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.calculator-title {
  font-size: 24px;
  margin-bottom: 20px;
  color: #333;
}

.calculator-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-label {
  font-weight: 500;
  color: #4a4a4a;
}

.form-input,
.form-select {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.form-input:focus,
.form-select:focus {
  border-color: #007BFF;
  outline: none;
  box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.button-group {
  display: flex;
  gap: 8px;
}

.btn {
  padding: 10px 16px;
  border-radius: 4px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  transition: background-color 0.2s;
}

.btn-primary {
  background-color: #007BFF;
  color: white;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

.btn-copy {
  background-color: #28a745;
  color: white;
}

.btn-copy:hover {
  background-color: #218838;
}

.result-container {
  margin-top: 24px;
  padding: 16px;
  background-color: #f8f9fa;
  border-radius: 4px;
}

.result-title {
  font-size: 18px;
  margin-bottom: 12px;
  color: #333;
}

.result-text {
  color: #4a4a4a;
  font-size: 16px;
}

.toast-notification {
  margin-top: 10px;
  padding: 10px;
  background-color: #28a745;
  color: white;
  border-radius: 4px;
  text-align: center;
  transition: opacity 0.5s;
}
</style>