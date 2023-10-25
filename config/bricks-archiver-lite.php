<?php
return [
    /*
    |--------------------------------------------------------------------------
    | regole di validazione del campo di upload
    |--------------------------------------------------------------------------
    |
    | Regola di validazione del campo files EG: 'image|max:2048' solo immagine di dimensione massima 2048
    | La regola può essere specificata anche all'interno del modello con la proprietà
    |
    |
    */
    'validation' => ['files.*' => 'required|image|max:2048'],

    /*
    |--------------------------------------------------------------------------
    | Support al package Easy Flux
    |--------------------------------------------------------------------------
    |
    | Abilita il supporto al Package Bricks Easy Flux
    |
    */
    'easy_flux_support' => false,

    /*
    |--------------------------------------------------------------------------
    | template del package Easy Flux
    |--------------------------------------------------------------------------
    |
    | Di default Easy Flux ha un suo template, ma è possibile specificarne uno sia
    | direttamente nel template di archiver lite oppure se non si vuole modificare il template di archiver lite
    | specificando il nome del template in quest variabile
    |
    */
    'easy_flux_template' => 'bricks-flux::livewire.flux'


];
