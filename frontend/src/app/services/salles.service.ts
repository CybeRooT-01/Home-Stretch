import { Injectable } from '@angular/core';
import { RestResponse } from '../interfaces/RestResponse';
import { RestService } from './rest-service.service';
import { Salles } from '../interfaces/Salles';

@Injectable({
  providedIn: 'root',
})
export abstract class SallesService extends RestService<RestResponse<Salles>> {
  override uri(): string {
    return 'salles';
  }
}
