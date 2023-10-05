import { Injectable } from '@angular/core';
import {RestService} from "./rest-service.service";
import {RestResponse} from "../interfaces/RestResponse";
import {Module} from "../interfaces/Modules";

@Injectable({
  providedIn: 'root'
})
export abstract class ModuleService extends RestService<RestResponse<Module>>{

  override uri(): string {
    return "modules";
  }
}
