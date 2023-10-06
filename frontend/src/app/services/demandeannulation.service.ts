import { Injectable } from '@angular/core';
import {RestResponse} from "../interfaces/RestResponse";
import {RestService} from "./rest-service.service";

@Injectable({
  providedIn: 'root'
})
export abstract class DemandeannulationService extends RestService<RestResponse<DemandeannulationService>>{
  override uri(): string {
    return "demandeAnnulation";
  }
}
