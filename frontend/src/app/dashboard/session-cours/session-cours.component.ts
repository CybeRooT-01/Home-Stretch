import {Component, OnInit, ViewChild} from '@angular/core';
import {CalendarOptions} from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import {SessionCoursService} from 'src/app/services/session-cours.service';
import {AuthService} from "../../services/auth.service";
import {DemandeannulationService} from "../../services/demandeannulation.service";
import {DemandeAnnulation} from "../../interfaces/DemandeAnnulation";
import notification from 'sweetalert2';
import {FullCalendarComponent} from "@fullcalendar/angular";
import {AbsenceService} from "../../services/absence.service";

@Component({
  selector: 'app-session-cours',
  templateUrl: './session-cours.component.html',
  styleUrls: ['./session-cours.component.css'],
})
export class SessionCoursComponent implements OnInit {
  isProf: boolean = false;
  profId: any;
  isEtudiant: boolean = false;
  isAttache: boolean = false;
  idEtudiant: number;
  data: any[] = [];
  dataByProf: any[] = [];
  evenementsFullCalendar: any[] = [];

  constructor(
    private sessionCoursService: SessionCoursService,
    private authService: AuthService,
    private demandeannulationService:DemandeannulationService,
    private absenceService:AbsenceService) {
  }


  coursListe: any[] = [];
  dateSelectionnee: string = "2021-06-07"

  ngOnInit(): void {
    this.authService.getCurrentUser().subscribe((response: any) => {
      console.log(response.data)
      // this.serviceUserService.setUser(response.data);
      this.isProf = response.data.role.includes('Professeur');
      this.isAttache = response.data.role.includes('Attache');
      this.isEtudiant = response.data.role.includes('Etudiant');
      if (this.isProf) {
        let idProf = response.data.professeur.id;
        this.profId = idProf;
        this.sessionCoursService.All().subscribe((data: any) => {
            console.log("idProf " + idProf)
            console.log(data)
            this.dataByProf = data.filter((cours: any) => cours.cours.idProfesseur == idProf);
            console.log(this.dataByProf)

            this.coursListe = this.dataByProf.map((cours: any) => {
              return cours.date;
            });
            this.coursListe = this.coursListe.filter((item, index) => {
              return this.coursListe.indexOf(item) === index;
            });

            this.evenementsFullCalendar = this.dataByProf.map((cours: any) => {
              return this.fullcalendarMapper(cours);
            });
            this.calendarOptions.events = this.evenementsFullCalendar;
          }
        )
      }else if (this.isEtudiant){
        this.idEtudiant = response.data.etudiant.id;
        let classeEtudiant = response.data.classe.id
        this.sessionCoursService.All().subscribe((data: any) => {
          console.log(data)
          this.data = data.filter((cours: any) => cours.classe.id == classeEtudiant);
          console.log(this.data)

          this.coursListe = this.data.map((cours: any) => {
            return cours.date;
          });
          this.coursListe = this.coursListe.filter((item, index) => {
            return this.coursListe.indexOf(item) === index;
          });

          this.evenementsFullCalendar = this.data.map((cours: any) => {
            return this.fullcalendarMapper(cours);
          });
          this.calendarOptions.events = this.evenementsFullCalendar;
        })
      } else {
        this.sessionCoursService.All().subscribe((data: any) => {
          this.data = data;
          console.log(this.data)
          this.coursListe = this.data.map((cours: any) => {
            return cours.date;
          });
          this.coursListe = this.coursListe.filter((item, index) => {
            return this.coursListe.indexOf(item) === index;
          });
          this.evenementsFullCalendar = this.data.map((cours: any) => {
            return this.fullcalendarMapper(cours);
          });
          this.calendarOptions.events = this.evenementsFullCalendar;
        });
      }
    });
  }
  fullcalendarMapper(cours: any){
    const dateDebut = new Date(`${cours.date}T${cours.heure_debut}`);
    const dateFin = new Date(`${cours.date}T${cours.heure_fin}`);
    const title = `${cours.cours.module} - ${cours.cours.nom_professeur} - ${cours.salle.nom}`;
    return {
      classe: cours.classe.libelle,
      prof: cours.cours.nom_professeur,
      cours: cours.cours.module,
      salle: cours.salle.nom,
      date: cours.date,
      horaires: `${cours.heure_debut} - ${cours.heure_fin}`,
      filiere: cours.classe.filiere,
      dateCour: cours.date,
      session_id: cours.id,
      title: title,
      start: dateDebut,
      end: dateFin,
      color: cours.validee === 1 ? 'red' : 'blue',
    };
  }
  calendarOptions: CalendarOptions = {
    plugins: [timeGridPlugin],
    initialView: 'timeGridWeek',
    headerToolbar: {
      left: 'prev,next',
      center: 'title',
      right: 'timeGridWeek,timeGridDay',
    },
    editable: true,
    eventClick: this.handleDateSelect.bind(this),
    locale: 'fr',
    selectable: true,
    select: this.handleDateRangeSelect.bind(this),
    initialDate: this.dateSelectionnee,
    // initialDate: "2021-06-07"
  };


  @ViewChild('calendar') CalendarComponent: FullCalendarComponent;
  private calendarApi: any;
  filtrerParDate(e:any) {
    this.calendarOptions.initialDate = this.dateSelectionnee;
    this.calendarOptions.events = this.evenementsFullCalendar.filter((cours: any) => cours.dateCour === this.dateSelectionnee);
    this.CalendarComponent.getApi().gotoDate(this.dateSelectionnee);
  }
  handleDateRangeSelect(arg: any) {
    console.log(arg)
  }
  profToDisplay: string = "";
  classeToDisplay: string = "";
  coursToDisaplay: string = "";
  filiereToDisplay: string = "";
  dateToDisplay: string = "";
  horairesToDisplay: string = "";
  salleToDisplay: string = "";
  sessionsId: number = 0;

  isCourSelected: boolean = false;
  handleDateSelect(arg: any) {
    console.log(arg)
    let argToDisplay = arg.event._def.extendedProps;
    console.log(argToDisplay)
    this.profToDisplay = argToDisplay.prof;
    this.classeToDisplay = argToDisplay.classe;
    this.coursToDisaplay = argToDisplay.cours;
    this.filiereToDisplay = argToDisplay.filiere;
    this.dateToDisplay = argToDisplay.dateCour;
    this.horairesToDisplay = argToDisplay.horaires
    this.salleToDisplay = argToDisplay.salle;
    this.sessionsId = argToDisplay.session_id;
    console.log(argToDisplay.session_id)
    if (this.profToDisplay !=="") {
      this.isCourSelected = true;
    }
  }

  demande: string = "";
  insultes = ["merde", "con", "connard", "emmerde","foutre"];
  isInsulte: boolean = false;
  checkInsulte(event: any) {
    this.isInsulte = this.insultes.includes(event.target.value.toLowerCase());
    console.log(this.isInsulte)
  }

  demanderAnnulation() {
    let data :DemandeAnnulation = {
      motif: this.demande,
      professeur_id: this.profId,
      session_cours_id: this.sessionsId
    }
    this.demandeannulationService.create(data).subscribe((response: any) => {
      console.log(response)
      this.ngOnInit();
      this.demande = "";
      let modalclosebtn = document.getElementById("fermer");
      modalclosebtn?.click();
    })
  }

  validerCours() {
    const dataToUpdate: Partial<any> = {
      id: this.sessionsId,
    }
    console.log(dataToUpdate)
    // return;
    this.sessionCoursService.update(dataToUpdate).subscribe((response: any) => {
      console.log(response)
      this.ngOnInit();
      let modalclosebtn = document.getElementById("close");
      modalclosebtn?.click();
      notification.fire({
        title: 'Succès',
        icon: 'success',
        text: 'Cours validé avec succès',
      });
    })
  }
  marquerPresent() {
    let data: any = {
      sessionCours_id: this.sessionsId,
      etudiant_id: this.idEtudiant,
      date: this.dateToDisplay
    }
    this.absenceService.create(data).subscribe((response: any) => {
      console.log(response)
      this.ngOnInit();
      notification.fire({
        title: 'Succès',
        icon: 'success',
        text: response.message,
      });
    }, (error: any) => {
      console.log(error)
      notification.fire({
        title: 'Erreur',
        icon: 'error',
        text: error.message,
      });
    })
  }


}
