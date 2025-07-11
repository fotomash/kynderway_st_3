import { ref } from 'vue';

export function useCredits() {
  const userCredits = ref(0);

  const creditPackages = [
    {
      id: 1,
      name: 'Starter',
      credits: 5,
      price: 5,
      bonus_credits: 0,
      price_per_credit: 1,
    },
    {
      id: 2,
      name: 'Popular',
      credits: 10,
      price: 9,
      bonus_credits: 2,
      price_per_credit: 0.9,
      is_popular: true,
      savings_percentage: 10,
    },
  ];

  const purchaseCredits = async (packageId) => {
    const pkg = creditPackages.find(p => p.id === packageId);
    if (pkg) {
      userCredits.value += pkg.credits + (pkg.bonus_credits || 0);
    }
  };

  const deductCredits = (amount) => {
    if (userCredits.value >= amount) {
      userCredits.value -= amount;
      return true;
    }
    return false;
  };

  return { userCredits, creditPackages, purchaseCredits, deductCredits };
}
