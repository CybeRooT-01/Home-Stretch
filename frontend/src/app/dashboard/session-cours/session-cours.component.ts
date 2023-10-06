import {Component, OnInit} from '@angular/core';
import {CalendarOptions} from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import {SessionCoursService} from 'src/app/services/session-cours.service';
import {AuthService} from "../../services/auth.service";
import {DemandeannulationService} from "../../services/demandeannulation.service";
import {DemandeAnnulation} from "../../interfaces/DemandeAnnulation";

@Component({
  selector: 'app-session-cours',
  templateUrl: './session-cours.component.html',
  styleUrls: ['./session-cours.component.css'],
})
export class SessionCoursComponent implements OnInit {
  isProf: any;
  profId: any;
  data: any[] = [];
  dataByProf: any[] = [];
  evenementsFullCalendar: any[] = [];

  constructor(
    private sessionCoursService: SessionCoursService,
    private authService: AuthService,
    private demandeannulationService:DemandeannulationService) {
  }

  ngOnInit(): void {
    this.authService.getCurrentUser().subscribe((response: any) => {
      console.log(response.data)
      this.isProf = response.data.role.includes('Professeur');
      if (this.isProf) {
        let idProf = response.data.professeur.id;
        this.profId = idProf;
        this.sessionCoursService.All().subscribe((data: any) => {
            console.log("idProf " + idProf)

            console.log(data)
            this.dataByProf = data.filter((cours: any) => cours.cours.idProfesseur == idProf);
            console.log(this.dataByProf)
            this.evenementsFullCalendar = this.dataByProf.map((cours: any) => {
              const dateDebut = new Date(`${cours.date}T${cours.heure_debut}`);
              const dateFin = new Date(`${cours.date}T${cours.heure_fin}`);
              const title = `${cours.cours.module} - ${cours.cours.nom_professeur} - ${cours.salle.nom}`;
              return {
                session_id: cours.id,
                classe: cours.classe.libelle,
                prof: cours.cours.nom_professeur,
                cours: cours.cours.module,
                salle: cours.salle.nom,
                date: cours.date,
                horaires: `${cours.heure_debut} - ${cours.heure_fin}`,
                filiere: cours.classe.filiere,
                dateCour: cours.date,
                title: title,
                start: dateDebut,
                end: dateFin,
                color: cours.validee === 1 ? 'red' : 'blue',

              }
            });
            this.calendarOptions.events = this.evenementsFullCalendar;
          }
        )
      } else {
        this.sessionCoursService.All().subscribe((data: any) => {
          this.data = data;
          console.log(this.data)
          this.evenementsFullCalendar = this.data.map((cours: any) => {
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
              title: title,
              start: dateDebut,
              end: dateFin,
              color: cours.validee === 1 ? 'red' : 'blue',
            };
          });
          this.calendarOptions.events = this.evenementsFullCalendar;
        });
      }
    });


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
  };
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
    if (this.profToDisplay !=="") {
      this.isCourSelected = true;
    }
  }

  demande: string = "";
  insultes = ["merde", "con", "connard", "salope", "pute", "pd", "pédé", "enculé", "encule", "enculer", "batard", "bâtard", "bougnoul", "bougnoule", "bouffon", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls", "bouffonne", "bouffonnes", "bouffons", "bougnoules", "bougnouls"];
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
}
