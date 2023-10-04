import { Injectable } from '@angular/core';
import {RestService} from "./rest-service.service";
import {RestResponse} from "../interfaces/RestResponse";
import {Cours} from "../interfaces/Cours";
@Injectable({
  providedIn: 'root'
})
export abstract class CoursService extends RestService<RestResponse<Cours>>{
  override uri(): string {
    return "cours";
  }
}
