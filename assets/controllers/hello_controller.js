import { Controller } from 'stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
        
    }
    // note(){
    //     // on va chercher toutes les étoiles
    //     const stars = this.element.querySelectorAll(".fa-star");
    //     console.log(stars);
    //     // on va chercher l'imput
    //     const note = this.element.querySelectorAll("#note");

    //     // on va boucler sur les étoiles pour ajouter des écouteurs d'évenements
    //     for(star of stars){

    //     }
    // }

}
