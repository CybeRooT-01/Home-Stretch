import {Component, OnInit} from '@angular/core';
import {SallesService} from '../../services/salles.service';
import {Salles} from 'src/app/interfaces/Salles';
import {CoursService} from "../../services/cours.service";
import {Cours} from "../../interfaces/Cours";
import {AbstractControl, FormBuilder, FormGroup, Validators} from '@angular/forms';
import {BirahimValidator} from "../../validators/birahim.validator";
import {Classes} from "../../interfaces/Classes";
import {ClasseService} from "../../services/classe.service";
import {SessionCoursService} from "../../services/session-cours.service";
import notification from 'sweetalert2';
import {catchError} from "rxjs";

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
    }, {validators: BirahimValidator.heureDebutSuperieurAHeureFin});
  }


  onSubmit() {
    if (this.formulaire.valid) {
      const formData = this.formulaire.value;
      console.log(formData)
      let dateformatedwithbadformat = formData.date.toLocaleDateString();
      let dateformated = dateformatedwithbadformat.split('/').reverse().join('-');
      formData.date = dateformated;
      console.log(formData);
      let data: any = {
        cour_id: formData.cours,
        classe_id: formData.classe,
        salle_id: formData.salle,
        date: formData.date,
        heure_debut: formData.heureDebut,
        heure_fin: formData.heureFin,
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

  heureDebut: any = [
    {value: '08:00:00', heure: '08h'},
    {value: '09:00:00', heure: '09h'},
    {value: '10:00:00', heure: '10h'},
    {value: '11:00:00', heure: '11h'},
    {value: '12:00:00', heure: '12h'},
    {value: '13:00:00', heure: '13h'},
    {value: '14:00:00', heure: '14h'},
    {value: '15:00:00', heure: '15h'},
    {value: '16:00:00', heure: '16h'},
  ];

  HeureFin: any = [
    {value: '09:00:00', heure: '09h'},
    {value: '10:00:00', heure: '10h'},
    {value: '11:00:00', heure: '11h'},
    {value: '12:00:00', heure: '12h'},
    {value: '13:00:00', heure: '13h'},
    {value: '14:00:00', heure: '14h'},
    {value: '15:00:00', heure: '15h'},
    {value: '16:00:00', heure: '16h'},
    {value: '17:00:00', heure: '17h'},
  ];
}
