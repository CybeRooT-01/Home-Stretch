import { Component} from '@angular/core';
import * as XLSX from 'xlsx';
import {EtudiantService} from '../../services/etudiant.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-inscription',
  templateUrl: './inscription.component.html',
  styleUrls: ['./inscription.component.css'],
})

export class InscriptionComponent{
  excelData: any;
  fileSelected: boolean = false;


  constructor(private etudiantservice: EtudiantService) {}
  readExcel(event: any) {
    let file = event.target.files[0];
    let extension = file.name.split('.').pop();
    if (extension !== 'xlsx'){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Veuillez choisir un format excel XSLX!',
      });
      return;
    }
    this.fileSelected = true;
    let fileReader = new FileReader();
    fileReader.readAsBinaryString(file);
    fileReader.onload = (e) => {
      let workbook = XLSX.read(fileReader.result, { type: 'binary' });
      let sheetNames = workbook.SheetNames;
      this.excelData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetNames[0]]);
      console.log(this.excelData)
    };
  }
  inscriptionErronee: any[] = [];
  inscription() {
    this.etudiantservice.create(this.excelData).subscribe(
      (res: any) => {
        console.log(res);
        this.inscriptionErronee = res.inscriptions_erronees.map((item: any) => {
          return {
            nomComplet: item.eleve.nomComplet,
            email: item.eleve.email,
            matricule: item.eleve.matricule,
            annee_id: item.eleve.annee_id,
            classe_id: item.eleve.classe_id,
            message: item.message,
          }
        });
        this.dataSource = this.inscriptionErronee;
        const inputFiles = document.getElementById(
          'multiple_files'
        ) as HTMLInputElement;
        if (res.status === 201) {
          this.fileSelected = false;
          inputFiles.value = '';
          this.excelData = [];
        }
      },
      (error: any) => {
        console.log(error);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Erreur Veuillez enlever les doublons et reessayer!',
        });
      }
    );
  }
  displayedColumns: string[] = ['nomComplet', 'email', 'matricule'];
  dataSource:any[] = this.inscriptionErronee;
}
