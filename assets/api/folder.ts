import { ClientData } from "../components/CardClient";
import { AttestationData } from "./attestation";
import { UserData } from "./user";

export type FolderData = {
	id: number,
	client: ClientData,
	creditAgent: UserData,
	attestations: AttestationData[]
	updatedAt: string,
}

export const getFolder = async (id?: string|null) => {
	if (id === undefined || id === null) throw new Error("Impossible ! l'identifiant n'est pas définit")
	try {
		const res = await fetch(`http://localhost:8000/api/folder/${id}`);
		
		if (!res.ok) {
			throw new Error(`Request failed with status ${res.status}`);
		}

		return res.json();
	} catch (error) {
		throw new Error(`An error occurred: ${error}`);
	}
  }