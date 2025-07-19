export function usePayment() {
  const processPayment = async ({ amount, description }) => {
    // console.log(`Processing payment of ${amount} for ${description}`);
    return { success: true, paymentMethodId: 'demo' };
  };

  return { processPayment };
}
