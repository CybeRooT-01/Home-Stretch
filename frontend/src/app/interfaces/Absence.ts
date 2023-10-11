import {RestResponse} from "./RestResponse";

export interface Absence extends RestResponse<Absence>{
  total_heurs_absance: number
  etudiant_id: number
  session_id: number
  date: string
}
