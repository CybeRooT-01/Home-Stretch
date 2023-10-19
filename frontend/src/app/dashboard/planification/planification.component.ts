import {Component, OnInit} from '@angular/core';
import {SallesService} from '../../services/salles.service';
import {Salles} from 'src/app/interfaces/Salles';
import {CoursService} from "../../services/cours.service";
import {Cours} from "../../interfaces/Cours";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {BirahimValidator} from "../../validators/birahim.validator";
import {Classes} from "../../interfaces/Classes";
import {ClasseService} from "../../services/classe.service";
import {SessionCoursService} from "../../services/session-cours.service";
import notification from "sweetalert2";

@Component({
  selector: 'app-planification',
  templateUrl: './planification.component.html',
  styleUrls: ['./planification.component.css'],
})
export class PlanificationComponent implements OnInit {
  salles: Salles[] = [];
  cours: Cours[] = [];
  classes: Classes[] = [];
  formulaire: FormGroup;


  constructor(private sessioncoursservice: SessionCoursService, private salleservice: SallesService, private classeservice: ClasseService, private courService: CoursService, private fb: FormBuilder) {
    this.formulaire = this.fb.group({
      salle: ['', Validators.required],
      cours: ['', Validators.required],
      date: ['', [Validators.required,BirahimValidator.dateValide]],
      heureDebut: ['', Validators.required],
      heureFin: ['', Validators.required],
      classe: ['', Validators.required],
      enligne: [false],
    }, {validators: BirahimValidator.heureDebutSuperieurAHeureFin});
    this.formulaire.get('enligne')?.valueChanges.subscribe(enligne => {
      if (enligne) {
        this.formulaire.get('salle')?.clearValidators();
        this.formulaire.get('salle')?.updateValueAndValidity();
        console.log(this.formulaire.valid)
      } else {
        this.formulaire.get('salle')?.setValidators(Validators.required);
        this.formulaire.get('salle')?.updateValueAndValidity();
      }
    });
  }




  onSubmit() {
    if (this.formulaire.valid) {
      const formData = this.formulaire.value;
      // console.log(formData)
      let dateformatedwithbadformat = formData.date.toLocaleDateString();
      let dateformated = dateformatedwithbadformat.split('/').reverse().join('-');
      formData.date = dateformated;
      // console.log(formData);
      let data: any = {
        cour_id: formData.cours,
        classe_id: formData.classe,
        salle_id: formData.salle,
        date: formData.date,
        heure_debut: formData.heureDebut+':00',
        heure_fin: formData.heureFin+':00',
        enligne: formData.enligne,
      }
      console.log(data)
      this.sessioncoursservice.create(data).subscribe((data: any) => {
          console.log(data);

        }, (error: any) => {
          console.error('Une erreur s\'est produite lors de la création :', error);
          notification.fire({
            title: 'Erreur',
            icon: 'error',
            text: error.message
          });
        }
      )
    } else {
      console.log('Formulaire invalide');
    }
  }

  ngOnInit(): void {
    this.salleservice.All().subscribe((data: Salles[]) => {
      this.salles = data;
    });
    this.courService.All().subscribe((data: Cours[]) => {
      this.cours = data;
    });
    this.classeservice.All().subscribe((data: Classes[]) => {
      this.classes = data;
    });
  }
}
