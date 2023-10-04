import { RestResponse } from './RestResponse';

export interface Salles extends RestResponse<Salles> {
  nom: string;
  numero: string;
  capacite: string;
}
