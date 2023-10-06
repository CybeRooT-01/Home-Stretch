import { Component, OnInit,OnDestroy } from '@angular/core';
import {DemandeannulationService} from "../../services/demandeannulation.service";
import {data} from "autoprefixer";

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

}
