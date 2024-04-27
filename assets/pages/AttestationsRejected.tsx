import { AttestationsRenderer, } from '../components/AttestationsRenderer'
import { useQuery } from '@tanstack/react-query'
import { getAllAttestation, groupeAttestationByDate } from '../api/attestation'
import { useMemo } from 'react'

export const AttestationsRejected = function()
{
  const { data, status, error } = useQuery({
    queryKey: ['rejected_attestation'],
    queryFn: () => getAllAttestation(),
  }) 
  const attestations = useMemo(() => groupeAttestationByDate(data), [data]);
  return <AttestationsRenderer data={attestations} status={status} error={error} />
}
