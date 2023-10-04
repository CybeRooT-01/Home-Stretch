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
      this.evenementsFullCalendar = this.data.map((cours: any) => {
        const dateDebut = new Date(`${cours.date}T${cours.heure_debut}`);
        const dateFin = new Date(`${cours.date}T${cours.heure_fin}`);
        const title = `${cours.cours.module} - ${cours.cours.nom_professeur} - ${cours.salle.nom}`;
        return {
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
  };

  handleDateSelect(arg: any) {
    console.log(arg.event._def);
  }
}
