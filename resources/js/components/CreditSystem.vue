<template>
  <div class="credit-system">
    <div class="credit-balance-widget">
      <div class="balance">
        <span>{{ userCredits }} Credits</span>
      </div>
      <button @click="showCreditPackages = true" class="buy-credits-btn">
        Buy Credits
      </button>
    </div>

    <modal v-model="showCreditPackages" title="Buy Credits">
      <div class="credit-packages">
        <div class="current-balance">
          <p>Current Balance: <strong>{{ userCredits }} Credits</strong></p>
        </div>

        <div class="packages-grid">
          <div
            v-for="pkg in creditPackages"
            :key="pkg.id"
            class="package-card"
            :class="{ popular: pkg.is_popular }"
            @click="selectPackage(pkg)"
          >
            <div v-if="pkg.is_popular" class="popular-badge">
              Most Popular
            </div>
            <h3>{{ pkg.name }}</h3>
            <div class="credits">
              <span class="amount">{{ pkg.credits }}</span>
              <span class="label">Credits</span>
              <span v-if="pkg.bonus_credits" class="bonus">
                +{{ pkg.bonus_credits }} Bonus
              </span>
            </div>
            <div class="price">
              <span class="currency">£</span>
              <span class="amount">{{ pkg.price }}</span>
            </div>
            <div class="per-credit">
              £{{ pkg.price_per_credit.toFixed(2) }} per credit
            </div>
            <div v-if="pkg.savings_percentage" class="savings">
              Save {{ pkg.savings_percentage }}%
            </div>
          </div>
        </div>

        <div class="package-benefits">
          <h4>What can you do with credits?</h4>
          <ul>
            <li>1 Credit - Send a message to a nanny</li>
            <li>3 Credits - Get 7-day access to a profile</li>
            <li>5 Credits - Unlock full permanent access</li>
            <li>Credits never expire</li>
          </ul>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useCredits } from '../composables/useCredits';
import { usePayment } from '../composables/usePayment';

export default {
  setup() {
    const {
      userCredits,
      creditPackages,
      purchaseCredits,
      deductCredits
    } = useCredits();

    const { processPayment } = usePayment();

    const showCreditPackages = ref(false);
    const selectedPackage = ref(null);

    const selectPackage = async (pkg) => {
      selectedPackage.value = pkg;
      const paymentResult = await processPayment({
        amount: pkg.price,
        description: `${pkg.credits} Credits`,
      });
      if (paymentResult.success) {
        await purchaseCredits(pkg.id, paymentResult.paymentMethodId);
        showCreditPackages.value = false;
        alert(`Successfully added ${pkg.credits + (pkg.bonus_credits || 0)} credits!`);
      }
    };

    const getUnlockCost = (type) => {
      if (type === 'message_only') return 1;
      if (type === 'temporary') return 3;
      if (type === 'full') return 5;
      return 0;
    };

    const performUnlockProfile = async (unlockType) => {
      const creditCost = getUnlockCost(unlockType);
      if (userCredits.value < creditCost) {
        showCreditPackages.value = true;
        return;
      }
      const confirmed = window.confirm(`This will use ${creditCost} credits. Continue?`);
      if (confirmed) {
        deductCredits(creditCost);
        alert('Profile unlocked!');
      }
    };

    return {
      userCredits,
      creditPackages,
      showCreditPackages,
      selectPackage,
      performUnlockProfile,
    };
  }
};
</script>

<style scoped>
.credit-balance-widget {
  position: fixed;
  top: 20px;
  right: 20px;
  background: white;
  border-radius: 8px;
  padding: 12px 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  gap: 16px;
  z-index: 100;
}

.packages-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin: 24px 0;
}

.package-card {
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  padding: 24px;
  text-align: center;
  cursor: pointer;
  position: relative;
  transition: all 0.3s;
}

.package-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.package-card.popular {
  border-color: #4CAF50;
  background: #f9fff9;
}

.popular-badge {
  position: absolute;
  top: -12px;
  left: 50%;
  transform: translateX(-50%);
  background: #4CAF50;
  color: white;
  padding: 4px 16px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: bold;
}
</style>
