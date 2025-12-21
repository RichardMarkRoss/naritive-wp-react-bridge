import type { Campaign } from "../types/Campaign";

function formatCurrency(value: number) {
  return new Intl.NumberFormat(undefined, { style: "currency", currency: "USD" }).format(value);
}

function badgeClass(status: string) {
  const base = "inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium";
  if (status === "active") return `${base} bg-green-100 text-green-800`;
  if (status === "paused") return `${base} bg-yellow-100 text-yellow-800`;
  return `${base} bg-gray-100 text-gray-800`;
}

export default function CampaignTable({ rows }: { rows: Campaign[] }) {
  return (
    <div className="overflow-x-auto rounded border border-gray-200 bg-white">
      <table className="min-w-full text-sm">
        <thead className="bg-gray-50 text-left text-gray-700">
          <tr>
            <th className="px-4 py-3">Campaign</th>
            <th className="px-4 py-3">Client</th>
            <th className="px-4 py-3">Budget</th>
            <th className="px-4 py-3">Start Date</th>
            <th className="px-4 py-3">Status</th>
          </tr>
        </thead>

        <tbody>
          {rows.map((c) => (
            <tr key={c.id} className="border-t border-gray-200">
              <td className="px-4 py-3 font-medium">{c.title}</td>
              <td className="px-4 py-3">{c.client_name}</td>
              <td className="px-4 py-3">{formatCurrency(c.budget)}</td>
              <td className="px-4 py-3">{c.start_date || "—"}</td>
              <td className="px-4 py-3">
                <span className={badgeClass(c.status)}>{c.status}</span>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export { CampaignTable };
