import { Component, OnInit } from '@angular/core';
import { CalendarOptions } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import { SessionCoursService } from 'src/app/services/session-cours.service';

@Component({
  selector: 'app-session-cours',
  templateUrl: './session-cours.component.html',
  styleUrls: ['./session-cours.component.css'],
})
export class SessionCoursComponent implements OnInit {
  data: any[] = [];
  evenementsFullCalendar: any[] = [];
  constructor(private sessionCoursService: SessionCoursService) {}

  ngOnInit(): void {
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
          color: cours.validee === 1 ? 'red' : 'green' ,
        };
      });
      this.calendarOptions.events = this.evenementsFullCalendar;
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
  profToDisplay:string = "";
  classeToDisplay:string = "";
  coursToDisaplay:string = "";
  filiereToDisplay:string = "";
  dateToDisplay:string = "";
  horairesToDisplay:string = "";
  salleToDisplay:string = "";

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
  }
}
