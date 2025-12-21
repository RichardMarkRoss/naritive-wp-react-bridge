import type { CampaignListResponse, CampaignStatus } from "../types/Campaign";

const BASE_URL = import.meta.env.VITE_API_BASE_URL as string | undefined;

export type CampaignQuery = {
  page: number;
  per_page: number;
  search?: string;
  status?: CampaignStatus | "";
};

function buildQuery(params: CampaignQuery): string {
  const qs = new URLSearchParams();
  qs.set("page", String(params.page));
  qs.set("per_page", String(params.per_page));

  const search = params.search?.trim();
  if (search) qs.set("search", search);

  if (params.status !== undefined && params.status !== "") qs.set("status", params.status);

  return qs.toString();
}

export async function fetchCampaigns(params: CampaignQuery): Promise<CampaignListResponse> {
  if (!BASE_URL) {
    throw new Error(
      "VITE_API_BASE_URL is not set. Add it to dashboard/.env and restart the dev server."
    );
  }

  const url = `${BASE_URL}/campaigns?${buildQuery(params)}`;
  const res = await fetch(url, { headers: { Accept: "application/json" } });

  if (!res.ok) {
    const text = await res.text().catch(() => "");
    throw new Error(`API request failed (${res.status}). ${text}`);
  }

  return res.json() as Promise<CampaignListResponse>;
}
