

export const getAttestation = async (id?: string) => {
    if (id === undefined) throw new Error("Impossible ! l'identifiant n'est pas définit")
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
  