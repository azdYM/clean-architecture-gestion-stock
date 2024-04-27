import { useMutation, useQuery } from "@tanstack/react-query"
import { ClientData } from "../components/CardClient"
import { UserData } from "./user"
import { ErrorResponse } from "react-router-dom"
import { mutateResource } from "../pages/EvaluateGage"

export enum AttestationWorkflowPlaces {
  created,
  evaluated,
  pending_approval,
  approved,
  rejected,
  canceled,
}

export type AttestationGrouped = {
  updatedAt: string,
  data: AttestationData[]
}

export type AttestationData = {
  id: number,
  client: ClientData,
  evaluator: UserData,
  items: Gage[],
  evaluatorDescription: string,
  idCreditTypeTargeted: number,
  canEdit: boolean,
  canPrint?: boolean,
  canMountCredit?: boolean,
  updatedAt: string,
  rejected?: boolean,
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

export const fetchAttestation = function(idAttestation?: string) {
  const {data, status, refetch, error} = useQuery<AttestationData, ErrorResponse>({
    queryKey: ['attestationId', idAttestation],
    queryFn: () => getAttestation(idAttestation),
    enabled: !!idAttestation,
  })

  return {data, status, refetch, error}
}

export const getAttestation = async (id?: number|string|null) => {
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

export const approveAttestation = function(uri: string, onSuccess?: CallableFunction, onError?: CallableFunction) {
  const {mutate, status} = useMutation({
    mutationFn: () => {
      return mutateResource({}, uri, 'POST')
    },

    onError: (error, variables, context) => {
      onError && onError(error, variables, context)
    },

    onSuccess: (data) => {
      onSuccess && onSuccess(data)
    }
  })

  return {mutate, status}
}

/**
 * Regrouper les attestations par date en utilisant reduce
 * Trié du date le plus récent
 */
export const groupeAttestationByDate = function(data?: AttestationData[]) {
  if (!data) return undefined;

  const groupedByDate = data.reduce((acc, attestation) => {
    const dateKey = new Intl.DateTimeFormat('en-US').format(new Date(attestation.updatedAt))

    acc[dateKey] = acc[dateKey] || []
    acc[dateKey].push(attestation)

    return acc;
  }, {} as { [date: string]: AttestationData[] })

  // Convertir l'objet en tableau
  const result: AttestationGrouped[] = Object.entries(groupedByDate).map(
    ([date, data]) => ({
      updatedAt: date,
      data: data,
    })
  )

  // Trier le tableau par date la plus récente
  const sortedResult = result.sort((a, b) => new Date(b.updatedAt).getTime() - new Date(a.updatedAt).getTime());
  return sortedResult;
}

  