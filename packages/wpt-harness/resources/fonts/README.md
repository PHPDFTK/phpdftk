# Harness default font

`DejaVuSerif.ttf` is the WPT harness's default UA font — the fallback
`font-family` for text that matches no author `@font-face` / `font-family`.
Browsers render unstyled text in their default serif (Times), so a real
serif is used here. Without a default font, text has zero advance/height and
text-dependent reftests pass **blank** (test and reference both empty),
hiding real text-layout gaps.

Override with the `WPT_DEFAULT_FONT` env var (path to a .ttf/.otf/.woff);
set it to `none` for the legacy font-less mode.

DejaVu Serif is distributed under the permissive Bitstream Vera / DejaVu
license — see `DejaVuSerif-LICENSE.txt`.
