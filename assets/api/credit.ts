import { AttestationWorkflowPlaces } from "./attestation";
import { FolderData } from "./folder";
import { UserData } from "./user";

export type CreditData = {
	id: number,
	capital: number,
	duration: number,
	idADBankingFolder: number,
	code: string,
	startedAt: string,
	endAt: string,
	interest: number,
	currentPlace: keyof typeof AttestationWorkflowPlaces,
	folder: FolderData,
	creditAgent: UserData,
    contracts?: Array<ContractData>
	updatedAt: string,
}

export type ContractData = {
	id: number,
	content: string,
	articles: ArticleData[],
	labelsForSignature: LabelForSignature[],
	updatedAt: string
}

export type ArticleData = {
	title: string,
	description: string
}

export type LabelForSignature = {
	label: string
}

export const getCredit = async (id?: string|null) => {
	if (id === undefined || id === null) throw new Error("Impossible ! l'identifiant n'est pas définit")
	try {
		const res = await fetch(`http://localhost:8000/api/credit/${id}`);
		
		if (!res.ok) {
			throw new Error(`Request failed with status ${res.status}`);
		}

		return res.json();
	} catch (error) {
		throw new Error(`An error occurred: ${error}`);
	}
}

export const getAllCredit = async (): Promise<CreditData[]> => {
	try {
	  const res = await fetch(`http://localhost:8000/api/credits`);
	  
	  if (!res.ok) {
		throw new Error(`Request failed with status ${res.status}`);
	  }
  
	  return res.json();
	} catch (error) {
	  throw new Error(`An error occurred: ${error}`);
	}
  }