import { Component, OnInit,OnDestroy } from '@angular/core';
import {DemandeannulationService} from "../../services/demandeannulation.service";
import notification from 'sweetalert2';

@Component({
  selector: 'app-demande-annulation',
  templateUrl: './demande-annulation.component.html',
  styleUrls: ['./demande-annulation.component.css']
})
export class DemandeANnulationComponent implements OnInit, OnDestroy{

  constructor(
    private demandeAnnulationService: DemandeannulationService
  ) {
  }
 demandes: any[] = [];
  ngOnInit(): void {
    this.demandeAnnulationService.All().subscribe((data: any) => {
      this.demandes = data

    })
  }
  ngOnDestroy(): void {

  }

  rejetter(id: number) {
    this.demandeAnnulationService.delete(id).subscribe((data: any) => {
      this.demandes = this.demandes.filter((demande) => demande.id !== id);
      notification.fire({
        title: 'Succès',
        icon: 'success',
        text: 'Demande rejetée avec succès',
      });
    });
  }

  accepter(id: number, session_cours_id: number) {
    let data = {
      id: id,
      session_cours_id: session_cours_id
    }
    this.demandeAnnulationService.updateWithoutID(data).subscribe((data: any) => {
      this.ngOnInit();
      notification.fire({
        title: 'Succès',
        icon: 'success',
        text: 'Demande acceptée ! a present le cours est a reprogrammer',
      });
    });
  }
}
