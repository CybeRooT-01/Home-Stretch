import { Injectable } from '@angular/core';
import { Etudiant } from '../interfaces/Etudiants';
import { RestService } from './rest-service.service';
import { RestREsponse } from '../interfaces/RestResponse';

@Injectable({
  providedIn: 'root',
})
export abstract class EtudiantService extends RestService<
  RestREsponse<Etudiant>
  > {
  override uri(): string {
    return 'etudiants';
  }
}
