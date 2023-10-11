import {Component, OnInit} from '@angular/core';
import {AbsenceService} from "../../services/absence.service";
import notification from "sweetalert2";

@Component({
  selector: 'app-absences',
  templateUrl: './absences.component.html',
  styleUrls: ['./absences.component.css']
})
export class AbsencesComponent implements OnInit {

  absences: any[] = [];

  constructor(private absenceService: AbsenceService) {
  }

  ngOnInit(): void {
    this.absenceService.All().subscribe((data: any) => {
      this.absences = data.data;
      console.log(this.absences)
    })
  }

  ValiderPresence(id: number) {
    let data = {
      id: id,
    }
    this.absenceService.update(data).subscribe((response: any) => {
      console.log(response)
      notification.fire({
        title: 'Succès',
        icon: 'success',
        text: 'Données enregistrer avec succès',
      });
      this.ngOnInit();
    }, (error: any) => {
      notification.fire({
        title: 'Erreur',
        icon: 'error',
        text: 'une est survenue veuillez réessayer',
      });
    })
  }
}
