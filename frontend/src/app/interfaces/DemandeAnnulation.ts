import {RestResponse} from "./RestResponse";

export interface DemandeAnnulation extends RestResponse<DemandeAnnulation>{
  professeur_id: number
  session_cours_id: number
  motif: string
}

