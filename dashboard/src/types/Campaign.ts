export type CampaignStatus = "active" | "paused";

export type Campaign = {
  id: number;
  title: string;
  client_name: string;
  budget: number;
  start_date: string; // YYYY-MM-DD
  status: CampaignStatus;
};

export type CampaignListResponse = {
  data: Campaign[];
  meta: {
    page: number;
    per_page: number;
    total: number;
    total_pages: number;
  };
};
