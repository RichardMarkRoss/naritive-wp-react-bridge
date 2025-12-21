import type { CampaignStatus } from "../types/Campaign";

type Props = {
  search: string;
  onSearchChange: (v: string) => void;
  status: CampaignStatus | "";
  onStatusChange: (v: CampaignStatus | "") => void;

  onRefresh: () => void;
  refreshing?: boolean;
};

function RefreshIcon({ spinning }: { spinning?: boolean }) {
  return (
    <svg
      viewBox="0 0 24 24"
      className={`h-4 w-4 ${spinning ? "animate-spin" : ""}`}
      fill="none"
      stroke="currentColor"
      strokeWidth="2"
      strokeLinecap="round"
      strokeLinejoin="round"
      aria-hidden="true"
    >
      <path d="M21 12a9 9 0 1 1-2.64-6.36" />
      <path d="M21 3v6h-6" />
    </svg>
  );
}

export function TopBar({
  search,
  onSearchChange,
  status,
  onStatusChange,
  onRefresh,
  refreshing,
}: Props) {
  return (
    <div className="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <h1 className="text-xl font-semibold">Campaign Monitor</h1>
        <p className="text-sm text-gray-600">React + TypeScript dashboard consuming WordPress REST</p>
      </div>

      <div className="flex flex-col gap-2 md:flex-row md:items-center">
        <input
          value={search}
          onChange={(e) => onSearchChange(e.target.value)}
          placeholder="Search by client name..."
          className="w-full md:w-72 rounded border border-gray-300 px-3 py-2 text-sm outline-none focus:ring"
        />

        <select
          value={status}
          onChange={(e) => onStatusChange(e.target.value as CampaignStatus | "")}
          className="w-full md:w-44 rounded border border-gray-300 px-3 py-2 text-sm outline-none focus:ring"
        >
          <option value="">All statuses</option>
          <option value="active">Active</option>
          <option value="paused">Paused</option>
        </select>

        <button
          type="button"
          onClick={onRefresh}
          disabled={!!refreshing}
          className="inline-flex items-center justify-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 text-sm hover:bg-gray-50 disabled:opacity-50"
          title="Refresh"
          aria-label="Refresh campaigns"
        >
          <RefreshIcon spinning={!!refreshing} />
          <span className="md:hidden">Refresh</span>
        </button>
      </div>
    </div>
  );
}
