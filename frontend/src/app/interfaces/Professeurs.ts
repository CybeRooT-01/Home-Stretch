import {RestResponse} from "./RestResponse";
export interface Profs extends RestResponse<Profs>{
  nomComplet: string
  specialite: string
  grade: string
}
