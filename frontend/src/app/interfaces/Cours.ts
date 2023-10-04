import {RestResponse} from "./RestResponse";
export interface Cours extends RestResponse<Cours>{
  quota_horaire_globale: string
  module: string
  nom_professeur: string
  specialite_professeur: string
  grade_profeseur: string
}
