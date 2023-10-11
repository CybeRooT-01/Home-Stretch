import { Injectable } from '@angular/core';
import {RestResponse} from "../interfaces/RestResponse";
import {RestService} from "./rest-service.service";
import {Absence} from "../interfaces/Absence";

@Injectable({
  providedIn: 'root'
})
export class AbsenceService extends RestService<RestResponse<Absence>>{
  override uri(): string {
    return "absence";
  }

}
