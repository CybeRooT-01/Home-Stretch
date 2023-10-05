import { Component, OnInit } from '@angular/core';
import {ProfService} from "../../services/prof.service";
import {ModuleService} from "../../services/module.service";
import {Module} from "../../interfaces/Modules";
import {Profs} from "../../interfaces/Professeurs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CoursService} from "../../services/cours.service";

@Component({
  selector: 'app-cours',
  templateUrl: './cours.component.html',
  styleUrls: ['./cours.component.css']
})
export class CoursComponent implements OnInit{
  modules:Module[] = [];
  profs:Profs[] = [];
  formulaire: FormGroup;
  constructor(
    private coursService: CoursService,
    private profService: ProfService,
    private moduleService: ModuleService,
    private fb: FormBuilder
  ) {
    this.formulaire = this.fb.group({
      module: ['',Validators.required],
      prof: ['',Validators.required],
      quota: ['',Validators.required],
    });
  }

  ngOnInit(): void {
    this.profService.All().subscribe((response:Profs[]) => {
      this.profs = response;
    });
    this.moduleService.All().subscribe((response:Module[]) => {
      this.modules = response;
    })
  }

  onSubmit() {
    let data:any = {
      module_id: this.formulaire.value.module,
      professeur_id: this.formulaire.value.prof,
      quota_horaire_globale: parseInt(this.formulaire.value.quota),
    }
    this.coursService.create(data).subscribe((response:any) => {
      console.log(response);
      this.formulaire.reset()
    })
  }

  valueInput:string = ""
  validateInput($event:Event):void{
    this.valueInput = ($event.target as HTMLInputElement).value
    let newValue = this.valueInput.replace(/[^0-9]/g, "");
    if (this.valueInput !== newValue) {
      this.valueInput = newValue;
      ($event.target as HTMLInputElement).value = newValue;
    }
  }
}
