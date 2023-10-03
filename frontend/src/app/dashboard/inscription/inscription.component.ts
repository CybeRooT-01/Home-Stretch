import { Component } from '@angular/core';
import * as XLSX from 'xlsx';
import { EtudiantService } from '../../services/etudiant.service';
import Swal from 'sweetalert2';
@Component({
  selector: 'app-inscription',
  templateUrl: './inscription.component.html',
  styleUrls: ['./inscription.component.css'],
})
export class InscriptionComponent {
  excelData: any;
  fileSelected: boolean = false;
  constructor(private etudiantservice: EtudiantService) {}
  readExcel(event: any) {
    let file = event.target.files[0];
    this.fileSelected = true;
    let fileReader = new FileReader();
    fileReader.readAsBinaryString(file);
    fileReader.onload = (e) => {
      let workbook = XLSX.read(fileReader.result, { type: 'binary' });
      let sheetNames = workbook.SheetNames;
      this.excelData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetNames[0]]);
    };
  }
  inscription() {
    this.etudiantservice.create(this.excelData).subscribe(
      (res: any) => {
        console.log(res);
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
}
