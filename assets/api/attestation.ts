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
  idCreditTypeTargeted: number,
  canUpdate: boolean,
  canMountCredit?: boolean,
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

export const getAttestationForPawcredit = async (): Promise<AttestationData[]> => {
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

export const getClientAttestationsCanMountCredit = async function(folio: number): Promise<AttestationData[]> 
{
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

export const calculateTotalValues = function(items: Gage[]) {
  const initialValue = {
    totalValorisation: 0,
    totalGram: 0,
    averageValuationPerGram: 0
  };

  const result = items.reduce((accumulator, currentItem) => {
    // Calcul des valeurs totales
    accumulator.totalValorisation += currentItem.unitPrice * currentItem.quantity;
    accumulator.totalGram += currentItem.weight;

    // Calcul de la valeur moyenne par gramme
    accumulator.averageValuationPerGram =
      accumulator.totalValorisation / accumulator.totalGram;

    return accumulator;
  }, initialValue);

  return result;
}

  