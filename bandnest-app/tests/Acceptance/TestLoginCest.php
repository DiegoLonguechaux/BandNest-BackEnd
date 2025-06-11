<?php

use Tests\Support\AcceptanceTester;

class TestLoginCest
{

    public function loginWithValidCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('email', 'diego.longuechaux@gmail.com'); // adapte l'email si besoin
        $I->fillField('password', 'DiegoLonguechaux');
        $I->click('.loginBtn');
        $I->wait(2); // Attendre un peu pour que la redirection se fasse
        $I->see('Email'); // À adapter selon ce qui s'affiche après connexion réussie
    }
    
    public function loginWithInvalidCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', '1234');
        $I->click('.loginBtn');
        $I->wait(2); // Attendre un peu pour que le message d'erreur s'affiche
        $I->see('Échec de la connexion. Vérifiez vos identifiants.'); // À adapter selon le message exact affiché
    }
}