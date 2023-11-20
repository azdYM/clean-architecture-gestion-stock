import { ClientData } from "../components/CardClient"
import { UserData } from "./user"

export enum AttestationWorkflowPlaces {
  created,
  evaluated,
  pending_approval,
  approved,
  rejected,
  canceled,
}

export type AttestationData = {
  id: number,
  client: ClientData,
  evaluator: UserData,
  items: Gage[],
  evaluatorDescription: string,
  creditTypeTargeted: string,
  canUpdate: boolean,
  updatedAt: string,
  currentPlace: keyof typeof AttestationWorkflowPlaces,
}

export type Gage = {
  id: number,
  name: string,
  quantity: number,
  carrat: number,
  unitPrice: number,
  weight: number,
  createdAt?: string,
  updatedAt?: string
}

export const getAttestation = async (id?: string|null) => {
  if (id === undefined || id === null) throw new Error("Impossible ! l'identifiant n'est pas définit")
  try {
    const res = await fetch(`http://localhost:8000/api/attestation/${id}`);
    
    if (!res.ok) {
      throw new Error(`Request failed with status ${res.status}`);
    }

    return res.json();
  } catch (error) {
    throw new Error(`An error occurred: ${error}`);
  }
}

export const getAllAttestation = async (): Promise<AttestationData[]> => {
  try {
    const res = await fetch(`http://localhost:8000/api/attestations`);
    
    if (!res.ok) {
      throw new Error(`Request failed with status ${res.status}`);
    }

    return res.json();
  } catch (error) {
    throw new Error(`An error occurred: ${error}`);
  }
}

  