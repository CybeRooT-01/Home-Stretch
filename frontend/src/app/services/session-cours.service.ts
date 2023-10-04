import { Injectable } from '@angular/core';
import { RestService } from './rest-service.service';
import { RestResponse } from '../interfaces/RestResponse';

@Injectable({
  providedIn: 'root',
})
export abstract class SessionCoursService extends RestService<
  RestResponse<any>
> {
  override uri(): string {
    return 'sessioncours';
  }
}
