 //// <reference types="cypress" />

 context('Actions', () => {
    before(() => {
      cy.visit('http://localhost:8000/login')
      
      Cypress.on('uncaught:exception', (err, runnable) => {
        // returning false here prevents Cypress from failing the test due to jquery error
        return false
        });
    })

    //log into the application
    it('Testing the Login functionality', () => {
        // type into username feild
        cy.get('#email', { delay: 200 })
          .type('mosesegboh@yahoo.com').should('have.value', 'mosesegboh@yahoo.com')

        // type into password field
        cy.get('#password', { delay: 300 })
        .type('dangerman').should('have.value', 'dangerman')
    
        //click on the login button
        cy.get('#authbutton').click()

        cy.wait(200)
    })

    //testing the creation of new stock
    it('Testing the creation of a new stock', () => {
        // type into password field
        cy.get('#colFormLabelLg', { delay: 300 })
        .type('Auto Test Company one').should('have.value', 'Auto Test Company one');
              
        //click on the profile button
        cy.get('#inlineFormInputGroup', { delay: 300 })
        .type('2').should('have.value', '2');

        cy.wait(200)

        //click on the add button to add stock
        cy.get('#addstock',{ delay: 300}).click()
        cy.wait(200)
        

        //confirming if the stock was actuallt saved
        cy.get('select', { delay: 300}).select('List of All Stocks')
        cy.wait(200)


        //the table should contain our entry
        cy.get('#stocktable',{ delay: 300}).contains('Sterling Bank')
        cy.wait(200)
    })

    //testing the logout functionality
    //log into the application
    it('Testing the Logout functionality', () => {
       
        //click on the drop
        cy.get('#navbarDropdown', {delay:200}).click()
        cy.wait(200)

        //confirm if we are on the dashboard
        cy.contains('Logout').click()
        cy.wait(200)
    })
})