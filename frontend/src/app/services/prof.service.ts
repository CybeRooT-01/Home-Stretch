import { Injectable } from '@angular/core';
import {RestResponse} from "../interfaces/RestResponse";
import {Profs} from "../interfaces/Professeurs";
import {RestService} from "./rest-service.service";

@Injectable({
  providedIn: 'root'
})

export abstract class ProfService extends RestService<RestResponse<Profs>>{
  override uri(): string {
    return "profs";
  }
}
