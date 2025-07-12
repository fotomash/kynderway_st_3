describe('Booking Flow', () => {
  it('allows a user to login and reach dashboard', () => {
    cy.visit('/login');
    cy.get('input[name="email"]').type('user@example.com');
    cy.get('input[name="password"]').type('password');
    cy.get('form').submit();
    cy.url().should('include', '/user/client');
  });
});
