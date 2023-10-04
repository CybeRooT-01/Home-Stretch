import { AbstractControl, ValidationErrors } from '@angular/forms';

export class BirahimValidator {
  static heureDebutSuperieurAHeureFin(control: AbstractControl): ValidationErrors | null {
    const heureDebutControl = control.get('heureDebut');
    const heureFinControl = control.get('heureFin');
    let realHeureDebut = heureDebutControl?.value.split(':')[0];
    let realHeureFin = heureFinControl?.value.split(':')[0];
    if(parseInt(realHeureDebut) >= parseInt(realHeureFin)){
      return {heureDebutSuperieurAHeureFin: true};
    }else {
      return null;
    }
  }
}
