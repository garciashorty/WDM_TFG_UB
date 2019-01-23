import numpy as np
import sys
#import matplotlib.pyplot as plt
import matplotlib.image as mpimg
from random import randint

def rgb2gray(rgb):
    return np.dot(rgb[...,:3], [0.299, 0.587, 0.114])

argumentos = sys.argv;
ruta = 'images/queries/images//'+sys.argv[1];

img = mpimg.imread(ruta)
gray = rgb2gray(img)
mpimg.imsave(ruta, gray)
print(randint(1, 3))
#plt.imshow(gray, cmap = plt.get_cmap('gray'))
#plt.show()
