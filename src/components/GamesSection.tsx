import { ArrowRight, Heart } from "lucide-react";

import sportsImg from "@/assets/sports-card.jpg";
import casinoImg from "@/assets/casino-card.jpg";
import politicsImg from "@/assets/politics-card.jpg";
import coinflipImg from "@/assets/coinflip-card.jpg";
import diceImg from "@/assets/dice-card.jpg";
import wheelImg from "@/assets/wheel-card.jpg";

interface GameCardProps {
  image: string;
  title: string;
  category: string;
  players: string;
}

const GameCard = ({ image, title, category, players }: GameCardProps) => (
  <div className="group relative rounded-xl overflow-hidden glass glass-hover cursor-pointer">
    <div className="aspect-[4/3] overflow-hidden">
      <img
        src={image}
        alt={title}
        className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
      />
      <div className="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent" />
    </div>
    <div className="absolute bottom-0 left-0 right-0 p-4">
      <span className="text-xs text-primary font-semibold uppercase tracking-wider">{category}</span>
      <h3 className="text-foreground font-semibold text-lg mt-1">{title}</h3>
      <div className="flex items-center justify-between mt-2">
        <span className="text-xs text-muted-foreground">{players} playing</span>
        <div className="flex items-center gap-2">
          <button className="p-1.5 rounded-md text-muted-foreground hover:text-primary transition-colors">
            <Heart className="w-4 h-4" />
          </button>
          <button className="p-1.5 rounded-md text-muted-foreground hover:text-primary transition-colors">
            <ArrowRight className="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>
  </div>
);

const games = [
  { image: sportsImg, title: "Sports Predictions", category: "Predictions", players: "12.5K" },
  { image: casinoImg, title: "Roulette", category: "Casino", players: "8.2K" },
  { image: politicsImg, title: "Political Predictions", category: "Predictions", players: "5.1K" },
  { image: coinflipImg, title: "Coin Flip", category: "Original", players: "15.3K" },
  { image: diceImg, title: "Dice Roll", category: "Casino", players: "9.7K" },
  { image: wheelImg, title: "Spin the Wheel", category: "Original", players: "11.4K" },
];

const GamesSection = () => {
  return (
    <section className="py-20 bg-background">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between mb-10">
          <div>
            <h2 className="font-display text-3xl md:text-4xl font-bold text-foreground">
              Popular Games
            </h2>
            <p className="text-muted-foreground mt-2">Trending games played by thousands</p>
          </div>
          <a href="#" className="hidden sm:flex items-center gap-2 text-primary text-sm font-medium hover:underline">
            View All <ArrowRight className="w-4 h-4" />
          </a>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {games.map((game) => (
            <GameCard key={game.title} {...game} />
          ))}
        </div>
      </div>
    </section>
  );
};

export default GamesSection;
