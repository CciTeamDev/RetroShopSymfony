import { Controller } from 'stimulus';


export default class extends Controller {
    connect() {


    }

    calcul(event){
        let carrier = event.currentTarget.querySelector("input:checked").value
        let ship = document.getElementById('ship')
        ship.innerHTML = carrier/100 + ' €'
        let soustot = this.element.getAttribute('data-total')
        console.log( carrier )
        console.log( soustot )

        let total = parseInt(carrier) + parseInt(soustot)
        tot.innerHTML = total/100 + ' €'
    }



}
