#!/usr/bin/env bash
# oracle.sh <engine> <abs-fixture-path> <out.png>  — real-browser render → 96dpi PNG
set -uo pipefail
eng="$1"; fx="$2"; out="$3"
pdf="$(mktemp).pdf"
node scripts/cross-browser/render.mjs "$eng" "$fx" --output="$pdf" 2>/tmp/oracle.err || { echo "RENDER FAIL"; cat /tmp/oracle.err; exit 1; }
gs -dNOPAUSE -dBATCH -dQUIET -sDEVICE=png16m -r96 -dFirstPage=1 -dLastPage=1 -sOutputFile="$out" "$pdf" 2>/dev/null
rm -f "$pdf"
