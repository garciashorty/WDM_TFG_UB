import numpy as np
import sys
import matplotlib.image as mpimg

def normalize(imagen):
    return np.real((imagen - np.min(imagen)) * 256 / (np.max(imagen) - np.min(imagen)))

def rgb2gray(rgb):
    return np.dot(rgb[...,:3], [0.299, 0.587, 0.114])

def max_color(imagen):
	img_r = img[:,:,0];
	img_g = img[:,:,1];
	img_b = img[:,:,2];

	m_r = np.mean(normalize(img_r));
	m_g = np.mean(normalize(img_g));
	m_b = np.mean(normalize(img_b));
	mayor = 1
	if m_r > m_g:
		if m_r < m_b:
			mayor = 3
	else:
		mayor = 2
		if m_g < m_b:
			mayor = 3

	return mayor

argumentos = sys.argv;
ruta = 'images\queries\images\\'+sys.argv[1];

img = mpimg.imread(ruta)
gray = rgb2gray(img)
mpimg.imsave(ruta, gray)
print max_color(img)
