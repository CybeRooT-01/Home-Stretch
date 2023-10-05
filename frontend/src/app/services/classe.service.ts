import { Injectable } from '@angular/core';
import {RestService} from "./rest-service.service";
import {RestResponse} from "../interfaces/RestResponse";
import {Classes} from "../interfaces/Classes";

@Injectable({
  providedIn: 'root'
})
export abstract class ClasseService extends RestService<RestResponse<Classes>>{
  override uri(): string {
    return "classes";
  }
}
