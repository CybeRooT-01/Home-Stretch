import {RestResponse} from "./RestResponse";

export interface Classes extends RestResponse<Classes>{
  libelle: string
  filiere: string
  niveau: string
}
