type Props = {
  page: number;
  totalPages: number;
  onPrev: () => void;
  onNext: () => void;
  disabled?: boolean;
};

export function Pagination({ page, totalPages, onPrev, onNext, disabled }: Props) {
  const canPrev = page > 1 && !disabled;
  const canNext = page < totalPages && !disabled;

  return (
    <div className="flex items-center justify-between">
      <p className="text-sm text-gray-600">
        Page <span className="font-medium">{page}</span> of{" "}
        <span className="font-medium">{Math.max(totalPages, 1)}</span>
      </p>

      <div className="flex gap-2">
        <button
          onClick={onPrev}
          disabled={!canPrev}
          className="rounded border border-gray-300 bg-white px-3 py-2 text-sm disabled:opacity-50"
        >
          Previous
        </button>

        <button
          onClick={onNext}
          disabled={!canNext}
          className="rounded border border-gray-300 bg-white px-3 py-2 text-sm disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>
  );
}
