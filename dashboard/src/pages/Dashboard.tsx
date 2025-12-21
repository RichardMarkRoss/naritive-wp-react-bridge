import React, { Suspense, useEffect, useMemo, useState } from "react";
import { fetchCampaigns } from "../api/campaigns";
import type { Campaign, CampaignStatus } from "../types/Campaign";
import { TopBar } from "../components/TopBar";
import { Pagination } from "../components/Pagination";

type LoadState = "idle" | "loading" | "success" | "error";

const CampaignTable = React.lazy(() => import("../components/CampaignTable"));

export function Dashboard() {
  const [rows, setRows] = useState<Campaign[]>([]);
  const [state, setState] = useState<LoadState>("idle");
  const [error, setError] = useState("");

  const [page, setPage] = useState(1);
  const perPage = 10;

  const [search, setSearch] = useState("");
  const [status, setStatus] = useState<CampaignStatus | "">("");

  const [totalPages, setTotalPages] = useState(1);

  const [refreshKey, setRefreshKey] = useState(0);

  const [debouncedSearch, setDebouncedSearch] = useState(search);
  useEffect(() => {
    const t = setTimeout(() => setDebouncedSearch(search), 350);
    return () => clearTimeout(t);
  }, [search]);

  useEffect(() => {
    setPage(1);
  }, [debouncedSearch, status]);

  const query = useMemo(
    () => ({
      page,
      per_page: perPage,
      search: debouncedSearch,
      status,
    }),
    [page, perPage, debouncedSearch, status]
  );

  useEffect(() => {
    let cancelled = false;

    async function load() {
      setState("loading");
      setError("");

      try {
        const res = await fetchCampaigns(query);
        if (cancelled) return;

        setRows(res.data);
        setTotalPages(res.meta.total_pages || 1);
        setState("success");
      } catch (e: any) {
        if (cancelled) return;

        setRows([]);
        setTotalPages(1);
        setState("error");
        setError(e?.message ?? "Unknown error");
      }
    }

    load();
    return () => {
      cancelled = true;
    };
  }, [query, refreshKey]);

  const isLoading = state === "loading";

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="mx-auto max-w-5xl px-4 py-8 space-y-6">
        <TopBar
          search={search}
          onSearchChange={setSearch}
          status={status}
          onStatusChange={setStatus}
          refreshing={isLoading}
          onRefresh={() => {
            setRefreshKey((k) => k + 1);
          }}
        />

        {state === "loading" && (
          <div className="rounded border border-gray-200 bg-white p-4 text-sm text-gray-700">
            Loading campaigns…
          </div>
        )}

        {state === "error" && (
          <div className="rounded border border-red-200 bg-white p-4 text-sm">
            <div className="font-medium text-red-700">Failed to load campaigns</div>
            <div className="mt-1 break-words text-red-700">{error}</div>
            <div className="mt-3 text-gray-700">
              Tip: confirm <code className="rounded bg-gray-100 px-1 py-0.5">VITE_API_BASE_URL</code>{" "}
              points to your WP site and that{" "}
              <code className="rounded bg-gray-100 px-1 py-0.5">/wp-json/naritive/v1/campaigns</code> loads in the browser.
            </div>
          </div>
        )}

        {state === "success" && rows.length === 0 && (
          <div className="rounded border border-gray-200 bg-white p-4 text-sm text-gray-700">
            No campaigns found for the current filters.
          </div>
        )}

        {rows.length > 0 && (
          <Suspense
            fallback={
              <div className="rounded border border-gray-200 bg-white p-4 text-sm text-gray-700">
                Loading table…
              </div>
            }
          >
            <CampaignTable key={refreshKey} rows={rows} />
          </Suspense>
        )}

        <Pagination
          page={page}
          totalPages={totalPages}
          disabled={isLoading}
          onPrev={() => setPage((p) => Math.max(1, p - 1))}
          onNext={() => setPage((p) => Math.min(totalPages, p + 1))}
        />
      </div>
    </div>
  );
}
