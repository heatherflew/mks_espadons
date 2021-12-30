# mks_espadons

Web tools for Mauna Kea Scholars (and others) to allow users to view ESPaDOnS spectra using a web browser

A live copy of this is hosted on github.io, and can be found at [https://heatherflew.github.io/mks_espadons] (https://heatherflew.github.io/mks_espadons/)

## Espadons Spectrum Viewer

This is a tool that allows the user to load up to 2 ESPaDOnS spectrum .s files and to display and examine the spectrum. It uses only html5, javascript and plotly. It works and has been tested on modern web browsers.  This tool was designed for 2 purposes:

1. Allow high school students an easy way to view ESPaDOnS spectra using only a web browser.

2. Allow astronomers to quickly view their own spectra.

You can try out this tool here -> [Espadons Spectrum Viewer](https://heatherflew.github.io/mks_espadons/espadonsviewer.html)

There is documentation for this tool here -> [User Guide](https://heatherflew.github.io/mks_espadons/user_guide.html)

## File format

ESPaDOnS produces data in [fits](https://en.wikipedia.org/wiki/FITS) format, which is a commonly used format in astronomy. If you are a PI of ESPaDOnS, you will also get a link to .s files, which are text files derived from the fits files. An example looks like this:

`
***Reduced spectrum of 'HD 225264'
 213831 2
  369.1296  3.5125e-01  2.1221e-01
  369.1319  1.6779e-01  2.0094e-01
  369.1343  6.5314e-01  2.2013e-01
  369.1366 -1.7128e-02  2.1596e-01
  369.1390  6.0087e-02  2.0024e-01
...
`

The first row is the name of the object observed - in this case, 'HD 225264',
which will be the name of the object loaded in the ESPaDOnS spectrum viewer.

The second row is the number of rows of data, followed by the number of
columnsafter the wavelength.

The remaining rows are the data. For this tool, it takes the first column as
the wavelength (in nm), and the second column as the intensity. Any
additional columns are ignored by this tool.

## Where to find ESPaDOnS data?

You can search the archives (generally, any data > 1 year old), at [CADC](https://www.cadc-ccda.hia-iha.nrc-cnrc.gc.ca/en/search/?collection=CFHT&noexec=true), by choosing ESPaDOnS as the instrument, plus other search parameters to narrow your selection.  The CADC only archives the fits files. If you are a student in need of a way to convert to .s files, please reach out to us, we can help.

